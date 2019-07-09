Vue.component("flash-wrapper", require("./components/flash-wrapper"));
Vue.component("flash", require("./components/flash"));
Vue.component("tabs", require("./components/tabs/tabs"));
Vue.component("tab", require("./components/tabs/tab"));
Vue.component("accordian", require("./components/accordian"));
Vue.component("tree-view", require("./components/tree-view/tree-view"));
Vue.component("tree-item", require("./components/tree-view/tree-item"));
Vue.component("tree-checkbox", require("./components/tree-view/tree-checkbox"));
Vue.component("tree-radio", require("./components/tree-view/tree-radio"));
Vue.component("modal", require("./components/modal"));
Vue.component("image-upload", require("./components/image/image-upload"));
Vue.component("image-wrapper", require("./components/image/image-wrapper"));
Vue.component("image-item", require("./components/image/image-item"));
Vue.directive("slugify", require("./directives/slugify"));
Vue.directive("code", require("./directives/code"));
Vue.directive("alert", require("./directives/alert"));
Vue.component("datetime", require("./components/datetime"));
Vue.component("date", require("./components/date"));
Vue.component("swatch-picker", require("./components/swatch-picker"));
Vue.directive("debounce", require("./directives/debounce"));

require('flatpickr/dist/flatpickr.css');

require('vue-swatches/dist/vue-swatches.min.css');

require("@babel/polyfill");

require('url-search-params-polyfill');

require('url-polyfill');