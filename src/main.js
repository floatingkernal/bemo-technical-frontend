import Vue from 'vue'
import App from './App.vue'
import store from './store'
import VModal from 'vue-js-modal'

Vue.config.productionTip = false
Vue.use(VModal, {dialog:true})

store.dispatch('loadBoard');

new Vue({
  store,
  render: h => h(App)
}).$mount('#app')
