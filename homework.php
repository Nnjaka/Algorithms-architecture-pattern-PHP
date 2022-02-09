<?php

/*1. Найти и указать в проекте Front Controller и расписать классы, которые с ним взаимодействуют.

Месторасположение файла - app/config/routing.php
С ним взаимодействуют все имеющиеся контроллеры:
    - MainController;
    - OrderController;
    - ProductController;
    - UserController;
Каждый Route вызывает у контроллеров соответствующий метод
*/


/*2. Найти в проекте паттерн Registry и объяснить, почему он был применён.

Месторасположение файла - app/framework/Registry.php

Применение:
    - для получения данных из конфигурационного файла по имени
    - для получения страницы по названию роута из RouteCollection
*/


/*3. Добавить во все классы Repository использование паттерна Identity Map вместо постоянного генерирования сущностей.*/
//Класс Product(Product.php)
class IdentityMapProduct
{
    private $identityMap = [];

    public function add(Product $product)
    {
        $key = $this->getGlobalKey(get_class($product), $product->getId());

        $this->identityMap[$key] = $product;
    }

    public function get(string $classname, int $id)
    {
        $key = $this->getGlobalKey($classname, $id);

        if (isset($this->identityMap[$key])) {
            return $this->identityMap[$key];
        }
    }

    private function getGlobalKey(string $classname, int $id)
    {
        return sprintf('%s.%d', $classname, $id);
    }
}


class Product
{
    public $identityMap = new IdentityMapProduct();

    public function getProduct($id)
    {
        if (!isset($this->identityMap->get(get_class($this), $id))) {
            $this->identityMap->add(get_class($this), $id);
        }
        return $this->identityMap->get(get_class($this), $id);
    }
}


//Класс User(User.php)
class IdentityMapUser
{
    private $identityMap = [];

    public function add(User $user)
    {
        $key = $this->getGlobalKey(get_class($user), $user->getId());

        $this->identityMap[$key] = $user;
    }

    public function get(string $classname, int $id)
    {
        $key = $this->getGlobalKey($classname, $id);

        if (isset($this->identityMap[$key])) {
            return $this->identityMap[$key];
        }
    }

    private function getGlobalKey(string $classname, int $id)
    {
        return sprintf('%s.%d', $classname, $id);
    }
}

class User
{
    public $identityMap = new IdentityMapUser();

    public function getUser($id)
    {
        if (!isset($this->identityMap->get(get_class($this), $id))) {
            $this->identityMap->add(get_class($this), $id);
        }
        return $this->identityMap->get(get_class($this), $id);
    }
}
