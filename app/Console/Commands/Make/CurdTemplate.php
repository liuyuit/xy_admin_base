<?php

namespace App\Console\Commands\Make\Make\Make;

use Illuminate\Console\Command;

class CurdTemplate extends Command
{

    /**
     * 生成基本的curd模板
     * example: php artisan curd:template Conf/GamePackage --model=Config/GamePackage
     * php artisan curd:template Team/Test --model=Team/Test --permission=test
     * --indexComponent=tableColumn  --indexComponent=EnumTag --indexComponent=BooleanTag
     * --upsertComponent=input --upsertComponent=input --upsertComponent=input --upsertComponent=select --upsertComponent=BooleanTag
     * php: controller request list
     * vue: api  index upsert
     * path = Conf/Test  --model=Conf/Test
     * @var string
     */
    protected $signature = 'curd:template {path} {--model=model} {--api=path} {--permission=permission} {{--indexComponent=*}} {{--upsertComponent=*}}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'curd 基本模板生成';

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
        // Conf/Team
        $arg = $this->argument('path');

        if (!$arg) {
            $this->error('path is not found');
            return false;
        }
        $ex = explode('/', $arg);
        if (count($ex) == 1) {
            $this->error('console error');
            return false;
        }

        $this->path = $arg;
        $this->currentName = end($ex);
        $this->parentName = $ex[0];
        $this->options = $this->options();
        $this->currentNameLowercase = $this->nameTransform($this->currentName);

        $this->handleController();
        $this->handleRequest();
        $this->handleList();

//        if ($this->options['indexComponent']) {
//            $this->handleVueIndex();
//            $this->handleVueApi();
//        }
//
//        if ($this->options['upsertComponent']) {
//            $this->handleVueUpsert();
//        }

        return 0;
    }

    private $controllerNamespace = 'App\Http\Controllers\Admin\%s';
    private $requestUse = "use App\Http\Requests\Admin\%s\IndexRequest;\r\nuse App\Http\Requests\Admin\%s\StoreRequest;\r\nuse App\Http\Requests\Admin\%s\UpdateRequest;";
    private $listUse = 'use App\Lists\%sList;';
    private $modelUse = 'use App\Models\%s;';
    private $className = '%sController';
    private $listName = '%sList';
    private $modelName = '%s';
    private $controllerPath = 'app/Http/Controllers/Admin/%sController.php';

    private $path; //Conf/GamePackage
    private $parentName; // Conf
    private $currentName;   // GamePackage
    private $currentNameLowercase; // game-package
    private $options;

    public function handleController()
    {
        $template = str_replace([
            '{{namespace}}',
            '{{use-request}}',
            '{{use-list}}',
            '{{use-model}}',
            '{{class-name}}',
            '{{list-name}}',
            '{{model-name}}',
            '{{$model-name-lower}}',
        ], [
            sprintf($this->controllerNamespace, $this->parentName),
            sprintf($this->requestUse, $this->path, $this->path, $this->path),
            sprintf($this->listUse, $this->path),
            sprintf($this->modelUse, $this->options['model']),
            sprintf($this->className, $this->currentName),
            sprintf($this->listName, $this->currentName),
            sprintf($this->modelName, $this->currentName),
            sprintf($this->modelName, lcfirst($this->currentName)),
        ], $this->getControllerStub());

        $template = str_replace('/', '\\', $template);
        $path = base_path(sprintf($this->controllerPath, $this->path));
        file_put_contents($path, $template);
    }

    public function getControllerStub()
    {
        return file_get_contents(base_path('stubs/CurdTemplate/php/controller.stub'));
    }

    private $requestPath = 'app/Http/Requests/Admin/%s';

    public function handleRequest()
    {
        $template = str_replace([
            '{{namespace}}',
            '{{class-name}}',
        ], [
            sprintf('App\Http\Requests\Admin\%s', $this->path),
            'IndexRequest',
        ], $this->getRequestStub());
        $pathIndex = sprintf($this->requestPath, $this->path . '/IndexRequest.php');
        $pathIndex = base_path($pathIndex);
        if (!file_exists($pathIndex)) {
            mkdir(sprintf($this->requestPath, $this->path), 0777, true);
        }

        file_put_contents($pathIndex, $template);

        $template = str_replace([
            '{{namespace}}',
            '{{class-name}}',
        ], [
            sprintf('App\Http\Requests\Admin\%s', $this->path),
            'StoreRequest',
        ], $this->getRequestStub());
        $pathIndex = sprintf($this->requestPath, $this->path . '/StoreRequest.php');
        $pathIndex = base_path($pathIndex);
        file_put_contents($pathIndex, $template);

        $template = str_replace([
            '{{namespace}}',
            '{{class-name}}',
        ], [
            sprintf('App\Http\Requests\Admin\%s', $this->path),
            'UpdateRequest',
        ], $this->getRequestStub());
        $pathIndex = sprintf($this->requestPath, $this->path . '/UpdateRequest.php');
        $pathIndex = base_path($pathIndex);
        file_put_contents($pathIndex, $template);
    }

    public function getRequestStub()
    {
        return file_get_contents(base_path('stubs/CurdTemplate/php/request.stub'));
    }

    private $listPath = 'app/Lists/%s';

    public function handleList()
    {
        $template = str_replace([
            '{{namespace}}',
            '{{use-model}}',
            '{{class-name}}',
            '{{model-name}}',
        ], [
            sprintf('App\Lists\%s', $this->parentName),
            sprintf($this->modelUse, $this->options['model']),
            sprintf('%sList', $this->currentName),
            sprintf('%s', $this->currentName),

        ], $this->getListStub());

        $template = str_replace('/', '\\', $template);
        $dir = base_path(sprintf($this->listPath, $this->path));
        $path = $dir . 'List.php';

        $parentPath = base_path(sprintf($this->listPath, $this->parentName));
        if (!file_exists($parentPath)) {
            mkdir($parentPath, 0777, true);
        }

        file_put_contents($path, $template);
    }

    public function getListStub()
    {
        return file_get_contents(base_path('stubs/CurdTemplate/php/list.stub'));
    }

    private $apiPath = 'resources/js/api/%s';

    public function handleVueApi()
    {
        $api = strtolower($this->parentName) . '/' . $this->currentNameLowercase;
        $template = str_replace([
            '{{class-name}}',
            '{{class-name-slash}}',
        ], [
            $this->currentName,
            $api,
        ], $this->getVueApiStub());

        $path = $this->parentName . '/' . $this->currentNameLowercase . '.js';
        $path = base_path(sprintf($this->apiPath, $path));
        file_put_contents($path, $template);
    }

    public function getVueApiStub()
    {
        return file_get_contents(base_path('stubs/CurdTemplate/vue/api.stub'));
    }

    private $indexPath = 'resources/js/views/modules/%s';
    private $indexTableComponent = <<<EOF
          <el-table-column label="公会类型" prop="team.type" align="center">
            <template slot-scope="scope">
              %s
            </template>
          </el-table-column>
    EOF;

    public function handleVueIndex()
    {
        $components = $this->handleIndexComponents();
        $template = str_replace([
            '{{permission-name}}',
            '{{api-resource}}',
            '{{import-component}}',
            '{{content}}',
            '{{components}}',
        ], [
            $this->options['permission'],
            $this->parentName . '/' . $this->currentNameLowercase,
            $components[1],
            $components[0],
            $components[2],
        ], $this->getVueIndexStub());

        $dir = sprintf($this->indexPath, $this->nameTransform($this->parentName));
        $dir = base_path($dir);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $dir = $dir . '/' . $this->nameTransform($this->currentName);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $path = $dir . '/index.vue';
        file_put_contents($path, $template);
    }

    private function handleIndexComponents()
    {
        $components = $this->options['indexComponent'];
        $content = '';
        $import = '';
        $componentsMethod = '';
        foreach ($components as $v) {
            if (!array_key_exists($v, $this->components)) {
                continue;
            }
            $temp = $this->components[$v];
            if ($temp['default'] === 1) {
               // 默认的
                $content .= ($temp['template'] . PHP_EOL);
            } else {
                $content .= sprintf($this->indexTableComponent, $temp['template']) . PHP_EOL;
                $import .= ($temp['require'] . PHP_EOL);
                $componentsMethod .= ', ' . $v;
            }
        }
        return [$content, $import, $componentsMethod];
    }

    public function getVueIndexStub()
    {
        return file_get_contents(base_path('stubs/CurdTemplate/vue/index.stub'));
    }

    private $upsertFormComponent = <<<EOF
        <el-form-item label="平台币" prop="platform_coin">
          %s
        </el-form-item>
    EOF;

    public function handleVueUpsert()
    {
        $components = $this->handleUpsertComponents();
        $template = str_replace([
            '{{api-resource}}',
            '{{import-component}}',
            '{{content}}',
            '{{components}}',
        ], [
            $this->parentName . '/' . $this->currentNameLowercase,
            $components[1],
            $components[0],
            $components[2],
        ], $this->getVueUpsertStub());

        $dir = sprintf($this->indexPath, $this->nameTransform($this->parentName));
        $dir = base_path($dir);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $dir = $dir . '/' . $this->nameTransform($this->currentName);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $path = $dir . '/Upsert.vue';
        file_put_contents($path, $template);
    }

    private function handleUpsertComponents()
    {
        $components = $this->options['upsertComponent'];
        $content = '';
        $import = '';
        $componentsMethod = '';
        foreach ($components as $v) {
            if (!array_key_exists($v, $this->components)) {
                continue;
            }
            $temp = $this->components[$v];
            if ($temp['default'] === 1) {
                // 默认的
                $content .= ($temp['template'] . PHP_EOL);
            } else {
                $content .= sprintf($this->upsertFormComponent, $temp['template']) . PHP_EOL;
                $import .= ($temp['require'] . PHP_EOL);
                $componentsMethod .= ', ' . $v;
            }
        }
        return [$content, $import, $componentsMethod];
    }

    public function getVueUpsertStub()
    {
        return file_get_contents(base_path('stubs/CurdTemplate/vue/upsert.stub'));
    }

    public function nameTransform($str)
    {
        $return = [];
        foreach (str_split($str) as $k => $v) {
            $ord = ord($v);
            if ($ord >= 65 && $ord <= 90) {
                $return[] = '-';
                $return[] = strtolower($v);
            } else {
                $return[] = $v;
            }
        }

        return trim(implode('', $return), '-');
    }

    private function cleanTemplate($template)
    {
        return str_replace('/', '\\', $template);
    }

    private $components = [
        'tableColumn' => [
            'template' => '<el-table-column label="ID" prop="id" align="center" sortable="custom" width="80" />',
            'default' => 1,
        ],
        'EnumTag' => [
            'template' => '<enum-tag name="TeamType" :value="scope.row.team.type" />',
            'default' => 0,
            'require' => "import EnumTag from '@/components/Tag/EnumTag/index';",
        ],
        'BooleanTag' => [
            'template' => '<boolean-tag :value="scope.row.enable" :types="[\'success\', \'danger\']" :labels="[\'启用\', \'禁用\']" />',
            'default' => 0,
            'require' => "import BooleanTag from '@/components/Tag/BooleanTag/index';",
        ],
        'input' => [
            'template' => '<el-input v-model="dataForm.name" disabled placeholder="会员" />',
            'default' => 1,
        ],
        'select' => [
            'template' => <<<EOF
                <el-select v-model="dataForm.platform" placeholder="请选择">
                  <el-option v-for="item in platformOptions" :key="item.value" :label="item.label" :value="item.value" />
                </el-select>
            EOF,
            'default' => 1,
        ],
    ];
}
