<template>
    <div id="main">
          <navigationMenu></navigationMenu>
        <header id="header">
            <div class="header-content">
                 <h1>
                    Matching Card Game
                </h1>
            </div>
         
        </header>
        <div id="content">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>

  import navigationMenu from './components/Menu.vue'
  export default {
    data() {
      return {
        //
      }
    },
    components: {
      navigationMenu
    }
  }
</script>