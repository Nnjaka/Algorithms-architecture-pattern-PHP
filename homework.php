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
namespace Model\Repository;

use Model\Entity;

class Product
{
    public $identityMap;

    public function __construct()
    {
        $this->identityMap = IdentityMapProduct::getInstance();
    }

    /**
     * Поиск продуктов по массиву id
     *
     * @param int[] $ids
     * @return Entity\Product[]
     */
    public function search(array $ids = []): array
    {
        if (!count($ids)) {
            return [];
        }

        $productList = [];
        foreach ($ids as $id) {
            if ($this->identityMap->get('Product', $id)) {
                $item = $this->identityMap->get('Product', $id);
                $productList[] = new Product($item['id'], $item['name'], $item['price']);
            } else {
                foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
                    $product = new Product($item['id'], $item['name'], $item['price']);
                    $productList[] = $product;
                    $this->identityMap->add($product);
                }
            }
        }
        return $productList;
    }

    /**
     * Получаем все продукты
     *
     * @return Entity\Product[]
     */
    public function fetchAll(): array
    {
        $productList = [];
        foreach ($this->getDataFromSource() as $item) {
            $productList[] = new Product($item['id'], $item['name'], $item['price']);
        }

        return $productList;
    }

    /**
     * Получаем продукты из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $dataSource = [
            [
                'id' => 1,
                'name' => 'PHP',
                'price' => 15300,
            ],
            [
                'id' => 2,
                'name' => 'Python',
                'price' => 20400,
            ],
            [
                'id' => 3,
                'name' => 'C#',
                'price' => 30100,
            ],
            [
                'id' => 4,
                'name' => 'Java',
                'price' => 30600,
            ],
            [
                'id' => 5,
                'name' => 'Ruby',
                'price' => 18600,
            ],
            [
                'id' => 8,
                'name' => 'Delphi',
                'price' => 8400,
            ],
            [
                'id' => 9,
                'name' => 'C++',
                'price' => 19300,
            ],
            [
                'id' => 10,
                'name' => 'C',
                'price' => 12800,
            ],
            [
                'id' => 11,
                'name' => 'Lua',
                'price' => 5000,
            ],
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return in_array($dataSource[key($search)], current($search), true);
        };

        return array_filter($dataSource, $productFilter);
    }
}

class IdentityMapProduct
{
    public $identityMap = [];

    private static $instance;

    protected function __construct()
    {
    }

    public static function getInstance(): IdentityMapProduct
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

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


//Класс User(User.php)
class User
{
    public $identityMap;

    public function __construct()
    {
        $this->identityMap = IdentityMapUser::getInstance();
    }

    /**
     * Получаем пользователя по идентификатору
     *
     * @param int $id
     * @return Entity\User|null
     */
    public function getById(int $id)
    {
        if ($this->identityMap->get('User', $id)) {
            $user = $this->identityMap->get('User', $id);
            return $this->createUser($user);
        } else {
            foreach ($this->getDataFromSource(['id' => $id]) as $user) {
                $this->identityMap->add($user);
                return $this->createUser($user);
            }
        }

        return null;
    }

    /**
     * Получаем пользователя по логину
     *
     * @param string $login
     * @return Entity\User
     */
    public function getByLogin(string $login)
    {
        foreach ($this->getDataFromSource(['login' => $login]) as $user) {
            if ($user['login'] === $login) {
                return $this->createUser($user);
            }
        }

        return null;
    }

    /**
     * Фабрика по созданию сущности пользователя
     *
     * @param array $user
     * @return Entity\User
     */
    private function createUser(array $user)
    {
        $role = $user['role'];

        return new User(
            $user['id'],
            $user['name'],
            $user['login'],
            $user['password'],
            new Role($role['id'], $role['title'], $role['role'])
        );
    }

    /**
     * Получаем пользователей из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $admin = ['id' => 1, 'title' => 'Super Admin', 'role' => 'admin'];
        $user = ['id' => 1, 'title' => 'Main user', 'role' => 'user'];
        $test = ['id' => 1, 'title' => 'For test needed', 'role' => 'test'];

        $dataSource = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'login' => 'root',
                'password' => '$2y$10$GnZbayyccTIDIT5nceez7u7z1u6K.znlEf9Jb19CLGK0NGbaorw8W', // 1234
                'role' => $admin
            ],
            [
                'id' => 2,
                'name' => 'Doe John',
                'login' => 'doejohn',
                'password' => '$2y$10$j4DX.lEvkVLVt6PoAXr6VuomG3YfnssrW0GA8808Dy5ydwND/n8DW', // qwerty
                'role' => $user
            ],
            [
                'id' => 3,
                'name' => 'Ivanov Ivan Ivanovich',
                'login' => 'i**extends',
                'password' => '$2y$10$TcQdU.qWG0s7XGeIqnhquOH/v3r2KKbes8bLIL6NFWpqfFn.cwWha', // PaSsWoRd
                'role' => $user
            ],
            [
                'id' => 4,
                'name' => 'Test Testov Testovich',
                'login' => 'testok',
                'password' => '$2y$10$vQvuFc6vQQyon0IawbmUN.3cPBXmuaZYsVww5csFRLvLCLPTiYwMa', // testss
                'role' => $test
            ],
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return (bool) array_intersect($dataSource, $search);
        };

        return array_filter($dataSource, $productFilter);
    }
}

class IdentityMapUser
{
    public $identityMap = [];

    private static $instance;

    public static function getInstance(): IdentityMapUser
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

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
