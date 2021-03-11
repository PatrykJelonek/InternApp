# Dokumentacja REST API
Dokumentacja endpoint'ów API.  
<br>

> {info} Wszystkie adresy `URI` są poprzedzone przez `/api/`.  
> ** Przykład: `https://localhost/api/internships/1` **

---

## Praktyki

---

Poniżej znajdują się endpoint'y 

### <larecipe-badge type="danger" rounded>GET</larecipe-badge> 
```js
/internship
```
Zwraca liste wszystkich praktyk w systemie.

### <larecipe-badge type="success" rounded>GET</larecipe-badge>
```js
/internship/{internship_id}
```
Zwraca informacje o danej praktyce (`internship_id`).

### <larecipe-badge type="success" rounded>GET</larecipe-badge> 
```js 
/internship/{internship_id}/students
```
Zwraca listę studentów danej praktyki (`internship_id`).

### <larecipe-badge type="success" rounded>GET</larecipe-badge>
```js 
/internship/{internship_id}/students/{student_id}
```
Zwraca informacje o danym studencie (`student_id`) odbywającą daną praktykę (`internship_id`).

### <larecipe-badge type="success" rounded>GET</larecipe-badge>
```js 
/internship/{internship_id}/students/{student_id}/journal-entries
```
Zwraca informacje o wpisach w dzienniku praktyk danego studenta (`student_id`) odbywającego daną praktykę (`internship_id`).

### <larecipe-badge type="success" rounded>GET</larecipe-badge> 
```js 
/internship/{internship_id}/students/{student_id}/journal-entries/{journal_entry_id}
```
Zwraca informacje o danym wpisie w dzienniku (`journal_entry_id`) danego studenta (`student_id`) odbywającego daną praktykę (`internship_id`).

### <larecipe-badge type="success" rounded>GET</larecipe-badge> 
```js 
/internship/{internship_id}/students/{student_id}/tasks
```
Zwraca informacje o zadaniach danego studenta (`student_id`) odbywającego daną praktykę (`internship_id`).

### <larecipe-badge type="success" rounded>GET</larecipe-badge>
```uri 
GET /internship/{internship_id}/students/{student_id}/tasks/{task_id}
```
Zwraca informacje o danym zadaniu (`task_id`) danego studenta (`student_id`) odbywającego daną praktykę (`internship_id`).