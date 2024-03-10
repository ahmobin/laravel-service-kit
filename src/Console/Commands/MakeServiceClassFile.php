<?php

namespace Mobin\LaravelServiceKit\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceClassFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service class file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $segments = explode('/', $name);
        $className = ucfirst(array_pop($segments));
        $namespace = 'App\Http\Services\\' . implode('\\', array_map('ucfirst', $segments));
        $directory = app_path('Http/Services/' . implode('/', $segments));
        $fileName = "{$directory}/{$className}.php";

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($fileName)) {
            $this->error("Service {$className} already exists!");
            return;
        }

        $content = $this->generateServiceStub($namespace, $className);

        File::put($fileName, $content);

        $this->info("\n\u{00A0}\u{00A0}<options=bold;bg=blue;fg=white>\u{00A0}INFO\u{00A0}</> <fg=#fff>Service [app/Http/Services/{$name}] created successfully.</>\n");
    }

    protected function generateServiceStub($namespace, $className): string
    {
        return "<?php

namespace {$namespace};

class {$className}
{
    //
}";
    }

}
