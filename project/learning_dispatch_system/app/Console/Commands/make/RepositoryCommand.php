<?php
 
namespace App\Console\Commands\make;
 
use App\Services\Common\FilterService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
 
/**
 * リポジトリ層ひな型ファイル作成
 *  
 **/
class RepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name?}';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';
 
    private string $base;
    private array $splits;
    const LAYER = 'Repositories';
    const EXTENSION = '.php';
    const PERMISSION = 0755;
 
    public function __construct(){
        parent::__construct();
        $this->base = app_path(self::LAYER);
        $this->splits = [];
    }
 
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name');

        if(blank($name) || is_string($name) === false){
            $this->newLine();
            $this->error(__('message.argument.file_name'));
            $this->newLine();
            return Command::INVALID;
        }
 
        $path = $this->makeFile($name);
        
        $this->newLine();
        $this->info("Repository [{$path}] created successfully.");
        $this->newLine();
 
        return Command::SUCCESS;
    }
 
    public function makeFile(string $name): string
    {
        $this->makeDir($name);
 
        $contents = $this->getContents($name);
 
        $judge = boolVal(preg_match('/^\//', $name));
 
        $path = $judge ? $this->base . $name : $this->base . '/' . $name;
 
        $path .= self::EXTENSION;
 
        file_put_contents($path, $contents);
 
        return $path;
    }
 
    private function getContents(string $name): string
    {
        $_ = function($s){return $s;};

        if(count($this->splits) >= 1){
            $addNameSpace = str_replace('/', '\\', Str::beforeLast($name, '/'));
            
            if(boolVal(preg_match('/^\//', $name)) === false){
                $addNameSpace = '\\' . $addNameSpace;
            }
        }
        else{
            $addNameSpace = '';   
        }

        $name = Str::afterLast($name, '/');

        return <<<EOC
        <?php
 
        namespace App\\{$_(self::LAYER)}{$addNameSpace};
 
        use App\\{$_(self::LAYER)}\AbstractRepository;
 
        class {$name} extends AbstractRepository
        {
            public function getModelClass(): string
            {
                // return Model::class;
            }
        }
        EOC;
    }
 
    private function makeDir(string $name): void
    {
        $path = $this->base;

        if(file_exists($path) === false){
            mkdir($path, self::PERMISSION);
        }

        $judge = count(explode('/', $name)) > 1;

        if($judge === false) return;

        $this->splits = FilterService::filled(explode('/', Str::beforeLast($name, '/')));
 
        foreach($this->splits as $split){
            $path .= "/{$split}";
            if(file_exists($path)) continue;
            mkdir($path, self::PERMISSION);
        }
    }
}