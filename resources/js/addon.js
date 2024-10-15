import '../css/addon.css';

import Assetdrop from './components/Assetdrop.vue';

Statamic.booting(() => {
    Statamic.component('assetdrop', Assetdrop);
});