<?php

require 'Foo.php';

$class = 'PhpTest\Foo';

class App
{
    public function build($class)
    {

        $reflect = new ReflectionClass($class);
        if (!$reflect->isInstantiable()) {
            // 不能被实例化
            throw new Exception('cannot be instantiable');
        }
        // 可以实例化
        $constructor = $reflect->getConstructor();
        // 没有构造函数
        if (is_null($constructor)){
            return new $class;
        }
        // 有构造函数
        // 获取构造函数的参数
        $params = $constructor->getParameters();
        $dependencies = $this->getDependency($params);

        return $reflect->newInstanceArgs($dependencies);


    }

    public function getDependency($params)
    {
        $dependencies = [];
        foreach ($params as $param){
            // 获取class 参数
            $dependency = $param->getClass();
            if (is_null($dependency))
            {
                // 处理费class类型的依赖
                $dependencies[] = $this->resolveNullClass($param);
            }else {
                // 处理class类型的依赖
                $dependencies[] = $this->build($dependency->name);
            }
        }
        return $dependencies;
    }

    /**
     * @param $param
     * @return mixed
     * @throws Exception
     */
    public function resolveNullClass($param)
    {
        // 有没有默认值
        if($param->isDefaultValueAvailable()){
            // 有  返回
            return $param->getDefaultValue();
        }
        // 无  异常
        throw new Exception('no default value');

    }
}

$app = new App();
$object = $app->build($class);

var_dump($object);









