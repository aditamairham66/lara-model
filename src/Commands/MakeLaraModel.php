<?php

namespace Aditamairhamdev\LaraModel\Commands;

use Aditamairhamdev\LaraModel\Helpers\File;
use Aditamairhamdev\LaraModel\Helpers\General;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MakeLaraModel extends Command
{
    use File;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:lara-model {table=All} {--connection=mysql}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new model class with Library aditamairhamdev/lara-model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $getTable = $this->argument("table");
        $getConnection = $this->option("connection");

        if($getTable == "All") {
            $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
            foreach($tables as $table) {
                $this->generateByTable($table, $getConnection);
            }
        }else{
            $this->generateByTable($getTable, $getConnection);
        }
    }


    protected function generateByTable($getTable, $getConnection)
    {
        // make path folder
        $pathModels = self::appPath('Models');
        if(!file_exists($pathModels)) {
            @mkdir($pathModels, 0755);
        }
        $pathRepo = self::appPath('Repositories');
        if(!file_exists($pathRepo)) {
            @mkdir($pathRepo, 0755);
        }
        // $pathService = self::appPath('Services');
        // if(!file_exists($pathService)) {
        //     @mkdir($pathService, 0755);
        // }

        // get Primary Key From Table
        $getPrimaryKey = General::findPrimaryKey($getTable, $getConnection);
        // make class name from Table
        $className = Str::studly($getTable);

        // get base template model
        $getContentModels = file_get_contents(__DIR__.'/../Sources/model_temp.blade.php.stub');
        $getContentRepo = file_get_contents(__DIR__.'/../Sources/repo_temp.blade.php.stub');

        //Change Class name
        $getContentModels = str_replace('{class_name}', $className, $getContentModels);
        $getContentRepo = str_replace('{class_name}', $className, $getContentRepo);

        //Change Table Name
        $getContentModels = str_replace('{table_name}', $getTable, $getContentModels);
        $getContentRepo = str_replace('{table_name}', $getTable, $getContentRepo);

        if (!empty($getPrimaryKey)) {
            $valPrimary = self::contentPrimaryKey($getPrimaryKey);
            //Add Primary Key
            $getContentModels = str_replace('{primary_key}', $valPrimary, $getContentModels);
        }
        if (!empty($getConnection)) {
            $valConnection = self::contentConnection($getConnection);
            //Add Primary Key
            $getContentModels = str_replace('{connection}', $valConnection, $getContentModels);
        }
        
        if(file_exists("$pathModels/$className.php")) {
            $this->info($className." model already created!");
        }else{
            file_put_contents("$pathModels/$className.php", $getContentModels);
            $this->info($className." model has been created!");
        }
        if(file_exists("$pathRepo/$className"."Repository.php")) {
            $this->info($className." repository already created!");
        }else{
            file_put_contents("$pathRepo/$className"."Repository.php", $getContentRepo);
            $this->info($className." repository has been created!");
        }
    }

}
