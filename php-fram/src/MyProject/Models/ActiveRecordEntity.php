<?php
    namespace MyProject\Models;
    use MyProject\Services\Db;


    abstract class ActiveRecordEntity{
        protected $id;

        public function __set($name, $value){
            $camelCaseName = $this->underscoreToCamelCase($name);
            $this->$camelCaseName = $value;
        }

        private function underscoreToCamelCase(string $name): string
        {
            return lcfirst(preg_replace('#_#','',ucwords($name, '_')));
        }

        private function camelCaseToUnderscore(string $name): string
        {
            return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name)) ;
        }

        public function getId() {
            return $this->id;
        }

        public static function findAll(){
            $db = Db::getInstance();
            return $db->query('SELECT * FROM `'.static::getTableName().'`', [], static::class);
        }

        private function propertiesToDbFormat():array{
            $reflector = new \ReflectionObject($this);
            $proporties = $reflector->getProperties();
            $propertyNames = [];
            foreach($proporties as $property){
                $propertyName = $property->getName();
                $propertyDb = $this->camelCaseToUnderscore($propertyName);
                $propertyNames[$propertyDb] = $this->$propertyName;
            }
            return $propertyNames;
        }

        public static function getById(int $articleId): ?self{
            $db = Db::getInstance();
            $entityObject = $db->query('SELECT * FROM `'.static::getTableName().'` WHERE id = :id;', [':id' => $articleId], static::class);
            return $entityObject ? $entityObject[0] : null;
        }

        public static function getByArticleId(int $id): array
        {
          $db = Db::getInstance();
          $entities = $db->query('SELECT * FROM `'.static::getTableName().'` WHERE article_id = :id',
          [':id' => $id],
          static::class
          );

          return $entities;
        }

        public function save():void{
            $mappedProperties = $this->propertiesToDbFormat();
            if ($this->id !== null) $this->update($mappedProperties);
            else $this->insert($mappedProperties);
        }

        public function update(array $proporties){
            $colum2params = [];
            $param2value = [];
            $index = 1;

            foreach($proporties as $column => $value){
                $param = ':param'.$index;
                $colum2params[] = '`'.$column.'` = '.$param;
                $param2value[$param] = $value;
                $index++;
            }
            $sql = 'UPDATE `'.static::getTableName().'` SET '.implode(', ',$colum2params).' WHERE id = '.$this->id;
            $db = Db::getInstance();
            $db->query($sql, $param2value, static::class);

        }

        public function insert(array $proporties){
            $filterProperties = array_filter($proporties);
            $columArray = [];
            $paramArray = [];
            $param2value = [];
            foreach($filterProperties as $column => $value){
                $columArray[] = '`'.$column.'`';
                $param = ':'.$column;
                $paramArray[] = $param;
                $param2value[$param] = $value ;
            }
            // var_dump($columArray);
            // var_dump($paramArray);
            // var_dump($param2value);
            $sql = 'INSERT INTO '.static::getTableName().' ('.implode(', ', $columArray).') VALUES ('.implode(', ', $paramArray).')';
            //var_dump($sql);
            $db = Db::getInstance();
            $db->query($sql, $param2value, static::class);
        }

        public function delete(){
            $db = Db::getInstance();
            $db->query('DELETE FROM '.static::getTableName().' WHERE id = :id', [':id' => $this->id], static::class);
            $this->id = null;
            header('Location: /frame/www');
        }

        abstract protected static function getTableName():string;
    }

?>