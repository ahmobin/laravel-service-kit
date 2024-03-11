<?php

namespace Mobin\LaravelServiceKit\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepositoryClassFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {name : The name of the repository class file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $segments = explode('/', $name);
        $className = ucfirst(array_pop($segments));
        $namespace = 'App\Http\Repositories';
        if (!empty($segments)) {
            $namespace .= '\\' . implode('\\', array_map('ucfirst', $segments));
        }
        $directory = app_path('Http/Repositories/' . implode('/', $segments));
        $fileName = "{$directory}/{$className}.php";

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($fileName)) {
            $this->error("\n\u{00A0}\u{00A0}<options=bold;bg=red;fg=white>\u{00A0}ERROR\u{00A0}</> <fg=white>Repository {$className} already exists!</>\n");
            return;
        }

        if ($this->confirm('Do you want to extend an interface?')) {
            $interface = $this->ask('Enter the name of the interface to extend (e.g., MyInterface):');
            $interface = ucfirst($interface);
            $interfaceNamespace = $this->searchInterfaceNamespace($interface);
            if (!$interfaceNamespace) {
                $this->error("\n\u{00A0}\u{00A0}<options=bold;bg=red;fg=white>\u{00A0}ERROR\u{00A0}</> <fg=white>Interface {$interface} not found!</>\n");
                return;
            }

            $content = $this->generateServiceStubWithInterface($namespace, $className, $interfaceNamespace, $interface);
        } else {
            $content = $this->generateServiceStub($namespace, $className);
        }


        File::put($fileName, $content);

        $this->info("\n\u{00A0}\u{00A0}<options=bold;bg=blue;fg=white>\u{00A0}INFO\u{00A0}</> <fg=white>Repository [app/Http/Repositories/{$name}] created successfully.</>\n");
    }

    protected function searchInterfaceNamespace($interface)
    {
        // Implement your logic to search for the interface namespace
        // For example:
        $defaultNamespace = 'App\Http\Interfaces';
        $customNamespaces = [
            // Define custom namespaces if any
            // 'InterfaceName' => 'Namespace\To\Interface'
        ];

        if (isset($customNamespaces[$interface])) {
            return $customNamespaces[$interface];
        }

        return $defaultNamespace;
    }

    protected function generateServiceStub($namespace, $className): string
    {
        return "<?php

namespace {$namespace};

use Mobin\LaravelServiceKit\Repositories\BaseRepository;

class {$className} extends BaseRepository
{
    //
}";
    }


    protected function generateServiceStubWithInterface($namespace, $className, $interfaceNamespace, $interface): string
    {
        return "<?php

namespace {$namespace};

use Mobin\LaravelServiceKit\BaseRepository;
use {$interfaceNamespace}\\{$interface};

class {$className} extends BaseRepository implements {$interface}
{
    //
}";
    }

}
