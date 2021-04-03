# Interfaces

---

- [DefaultRepositoryInterface](#defaultRepositoryInterface)
	- [one](#defaultRepositoryInterfaceOne)
	- [all](#defaultRepositoryInterfaceAll)
	- [create](#defaultRepositoryInterfaceCreate)
	- [update](#defaultRepositoryInterfaceUpdate)
	- [delete](#defaultRepositoryInterfaceDelete)
- 
	
---

<a name="defaultRepositoryInterface"></a>
## DefaultRepositoryInterface
Przykładowy interface 

<a name="defaultRepositoryInterfaceOne"></a>
### One
```php
public function one(int $id);
```

<a name="defaultRepositoryInterfaceAll"></a>
### All
```php
public function all();
```

<a name="defaultRepositoryInterfaceCreate"></a>
### Create
```php
public function create(array $data, array $studentsIds = null);
```

<a name="defaultRepositoryInterfaceUpdate"></a>
### Update
```php
public function update(array $data);
```

<a name="defaultRepositoryInterfaceDelete"></a>
### Delete
```php
public function delete(int $id);
```