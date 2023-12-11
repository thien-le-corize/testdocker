<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Concerns\CreatesMatchingTest;

class GenerateActionCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:action {name} {--action=folder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Filesystem $files)
    {
        $name = $this->argument('name');
        $option = $this->option('action');
        $className = Str::studly($name);
        
        $folder = Str::studly($option);
        $contentStub = File::get(app_path('Console/Stubs/Action.stub'));
        $contentStub = str_replace('{{ class }}', $className, $contentStub);
        $contentStub = str_replace('{{ namespace }}', $option, $contentStub);
        $basePath = $this->laravel['path'] . '//Http//Actions//'.$folder.'//';

        $path = $basePath;
       
        $filePath = app_path('Http/Actions/'.$folder.'/' . $className . '.php');

        if (File::exists($filePath)) {
            $this->error('Content file already exists!');
            return;
        }

        $files->makeDirectory($path, 0777, true, true);
        $files->put($path . str_replace('\\', '/', $name .'.php'), $contentStub);

        $this->info('Content file generated successfully!');
    }
}
