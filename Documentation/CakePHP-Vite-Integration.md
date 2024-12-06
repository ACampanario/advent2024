# Integrate Vite for front side in CakePHP

## 1.- Create a new View

src/View/ViteView.php

```
declare(strict_types=1);

namespace App\View;

use Cake\View\View;

class ViteView extends View
{
    public function initialize(): void
    {
        $this->loadHelper('Vite');
    }
}
```

## 2.- Create a new Trait

src/Traits/ViteResponseTrait.php

```
namespace App\Traits;

use App\View\ViteView;
use Cake\Event\EventInterface;

trait ViteResponseTrait
{
    public function beforeRender(EventInterface $event)
    {
        $this->viewBuilder()->setClassName(ViteView::class);
    }
}
```

## 3.- Create a new Helper

src/View/Helper/ViteHelper.php

```
namespace App\View\Helper;

use Cake\Routing\Router;
use Cake\View\Helper;

/**
 * Vite helper
 */
class ViteHelper extends Helper
{
    public array $helpers = ['Html'];

    public function loadAssets(): string
    {
       if (!file_exists(WWW_ROOT . 'hot')) {
           $manifest = json_decode(
               file_get_contents(WWW_ROOT . 'js' . DS . 'manifest.json'),
               true
           );
           $path = Router::fullBaseUrl() . DS . 'js' . DS;
           $firstBlock = [];
           $secondBlock = [];
           foreach($manifest as $key => $data){
               $part = explode('.', $key);
               $part = $part[count($part) - 1];
               if ($part == 'css') {
                   $firstBlock[] = $this->Html->tag(
                       'link',
                       '',
                       ['as' => 'style', 'rel' => 'preload', 'href' => $path . $data['file']]
                   );
                   $secondBlock[] = $this->Html->tag(
                       'link',
                       '',
                       ['as' => 'style', 'rel' => 'stylesheet', 'href' => $path . $data['file']]
                   );
               }
               if ($part == 'js') {
                   $firstBlock[] = $this->Html->tag(
                       'link',
                       '',
                       ['as' => 'style', 'rel' => 'preload', 'href' => $path . $data['css'][0]]
                   );
                   $secondBlock[] = $this->Html->tag(
                       'link',
                       '',
                       ['as' => 'style', 'rel' => 'stylesheet', 'href' => $path . $data['css'][0]]
                   );
                   $firstBlock[] = $this->Html->tag(
                       'link',
                       '',
                       ['rel' => 'modulepreload', 'href' => $path . $data['file']]
                   );
                   $secondBlock[] = $this->Html->tag(
                       'script',
                       '',
                       ['type' => 'module', 'src' => $path . $data['file']]
                   );
               }
           }

           return implode('', $firstBlock) . implode('', $secondBlock);
       } else {
           $domain = file_get_contents(WWW_ROOT . 'hot');
           $head = $this->Html->script(
               $domain . '/@vite/client',
               ['rel' => 'preload', 'type' => 'module']
           );
           $head .= $this->Html->css($domain . '/resources/css/app.css');
           $head .= $this->Html->script(
               $domain . '/resources/js/app.js',
               ['rel' => 'preload', 'type' => 'module']
           );

           return $head;
       }
    }
}
```

## 4.- Create function vite and add the trait to the controller

src/Controller/PagesController.php

```
use App\Traits\ViteResponseTrait;

class PagesController extends AppController
{
    use ViteResponseTrait;

    public function vite()
    {
        $this->viewBuilder()->setLayout('vite');
    }
}
```

## 5.- Add a new layout

templates/layout/vite.php

```
<!DOCTYPE html>
<head lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cake with Vite and Vue</title>
        <?php echo $this->Vite->loadAssets();?>
    </head>
<body class="antialiased">
<div id="app">
    <example-component></example-component>
</div>
</body>
</html>
```

## 6.- Install and configure Vite (using DDEV)

on .ddev/config.yaml add this new configuration

```
web_extra_exposed_ports:
    - name: vite
    container_port: 5173
    http_port: 5172
    https_port: 5173
```

and run

```
ddev restart
```

create package.json

```
{
    "private": true,
    "type": "module",
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    },
    "devDependencies": {
        "autoprefixer": "^10.4.20",
        "laravel-vite-plugin": "^1.0.0",
        "vite": "^5.0.0"
    },
    "dependencies": {
        "@vitejs/plugin-vue": "^5.1.4",
        "vue": "^3.5.8",
        "vuex": "^4.0.2"
    }
}
```

create vite.config.js

```
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

const port = 5173;
const origin = `${process.env.DDEV_PRIMARY_URL}:${port}`;

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            publicDirectory: 'webroot',
            refresh: true,
        }),
        vue(),
    ],
    build: {
        outDir: 'webroot/js'
    },
    server: {
        host: '0.0.0.0',
        port: port,
        strictPort: true,
        origin: origin
    },
});
```

create .env

```
APP_NAME=cakePHP
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL="https://advent2024.ddev.site"
```

to install and configure all run in console

```
ddev npm install
```

## 7.- Create an Example App

resources/js/components/ExampleComponent.vue

```
<template>
  <div class="text-center p-4 bg-blue-100 rounded-lg">
    <h1 class="text-2xl font-bold">Hello from Vue 3!</h1>
    <p class="mt-2">This is a Vue component integrated with CakePHP and Vite.</p>
    <h2 class="mt-4">Counter: {{ count }}</h2>
    <p class="mt-2">
      <button @click="increment">Increment</button>
      <button @click="decrement">Decrement</button>
    </p>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'ExampleComponent',
  computed: {
    ...mapGetters(['getCount']),
    count() {
      return this.getCount;
    },
  },
  methods: {
    ...mapActions(['increment', 'decrement']),
  },
};
</script>

<style scoped>
button {
  margin: 5px;
}
</style>
```

resources/js/app.js

```
import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import store from './store';

createApp(ExampleComponent).use(store).mount('#app');
```

resources/js/store.js

```
import {createStore} from 'vuex';

const store = createStore({
    state: {
        count: Number(localStorage.getItem('count')) || 0,
    },
    mutations: {
        increment(state) {
            state.count++;
            localStorage.setItem('count', state.count);
        },
        decrement(state) {
            state.count--;
            localStorage.setItem('count', state.count);
        },
    },
    actions: {
        increment({ commit }) {
            commit('increment');
        },
        decrement({ commit }) {
            commit('decrement');
        },
    },
    getters: {
        getCount(state) {
            return state.count;
        },
    },
});
```

## 8.- Launch

For development run Vite

```
ddev npm run dev
```
https://i.imgur.com/BfqYX6N.png

For production run Vite build

```
ddev npm run build
```
https://i.imgur.com/qqJqdPn.png

This generates the assets directory inside webroot dir, the helper automatically load the files parsing the manifest.json

You can see in front the app

https://i.imgur.com/Qdot05S.png


