# Resources
Folder zawierający pliku typu `JsonResource`.

- [TaskResource](#taskResource)

---

<a name="taskResource"></a>
## TaskResource
**Kolekcja: ** [`TaskCollection`](/{{route}}/{{version}}/Backend/App/Http/Resources/Collections/index#taskCollection)

Zwraca tablice: 

Klucz | Typ | Opis
------ | ------ | -----
`id` | int | Identyfikator zadania
`name` | string | Nazwa zadania
`description` | string | Opis zadania
`user_id` | int | Identyfikator autora zadania
`done` | bool | Flaga czy zadanie zostało ukończone
`created_at` | timestamp | Data utworzenia zadania
`updated_at` | timestamp | Data statniej modyfikacji zadania