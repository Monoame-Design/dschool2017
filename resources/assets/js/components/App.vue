<template lang="pug">
div(:class="app_class")
  transition(name="fade")
    page_loading(v-if="loading")
  //Navbar
  page_nav
  .pages_area
    transition(name="page" mode="out-in")
      router-view(:key="$route.path")
  SectionFooter(v-show="$route.path!='/'")
    //- section_footer
</template>


<script>
import Navbar from './Navbar'
import SectionFooter from './Footer'
import page_loading from './pages/page_loading'
import {mapState,mapMutations} from 'vuex'
import page_nav from "../components/Pages/page_nav.vue"

export default {
  components: {
    Navbar,SectionFooter,page_loading,page_nav
  },
  computed: {
    ...mapState(['loading']),
    app_class(){
      let result =  ['route'+this.$route.path.replace(/\//g,'_')]
      if (this.loading){
        result.push("loading")
      }
      return result
    },
  }
}
</script>
