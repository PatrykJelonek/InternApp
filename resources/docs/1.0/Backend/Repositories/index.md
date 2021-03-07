# Repositories

---

- [InternshipRepository](/{{route}}/{{version}}/Backend/Repositories/InternshipRepository)
- [TaskRepository](/{{route}}/{{version}}/Backend/Repositories/TaskRepository)
- [JournalEntryRepository](/{{route}}/{{version}}/Backend/Repositories/JournalEntryRepository)
- [StudentRepository](/{{route}}/{{version}}/Backend/Repositories/StudentRepository)

---

<a name="taskRepository"></a>
## TaskRepository  
***extends*** [DefaultRepositoryInterface](/{{route}}/{{version}}/Backend/Repositories/Interfaces/index#defaultRespositoryInterface)

### One
Zwraca pojedyńczy obiekt `TaskResource`

### All
Zwraca kolekcje zadań typy `TaskCollection`

### Create
Metoda pozwalająca dodać zadanie do bazy danych. 
Zwraca obiekt typu `TaskResource`.

### Update
Metoda pozwalająca zaktualizować zadanie w bazie danych. 
Zwraca zaktualizowany obiekt typu `TaskResource`

### Delete 
Metoda pozwalająca usunąć zadanie z bazy danych.

---
