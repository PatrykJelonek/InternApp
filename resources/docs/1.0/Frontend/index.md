# Frontend

---

- [Components](#components)
- [Plugins](#plugins)
- [Router](#router)
- [Store](#store)
- [Views](#views)

---
<a name="components"></a>
## Components  [Vue](https://vuejs.org/v2/guide)
Folder zawierający komponenty Vue wykorzystywane w [widokach](#views). 

<a name="router"></a>
## Router 
[Vue Router](https://router.vuejs.org/guide/)
* `router.js` - zawiera tablice routingu obsługiwaną przez [Vue Router](https://router.vuejs.org/guide/)

<a name="store"></a>
## Store  [Vuex](https://vuex.vuejs.org/guide)
* `modules` - folder zawierający [moduły](https://vuex.vuejs.org/guide/modules.html).
* `index.js` - plik wiążący moduły z globalny obiektem vuex'a.
* `subscriber.js` - plik zawiera logikę sprawdzającą [token JWT](https://jwt.io/)

<a name="views"></a>
## Views  [Vue](https://vuejs.org/v2/guide)
Folder zawierający główne widoki strony.