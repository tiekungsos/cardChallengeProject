<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <a class="navbar-brand" href="#">Matching Card</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active"  v-if="!$auth.check()" v-for="(route, key) in routes.unlogged" v-bind:key="route.path">
                    <router-link class="nav-link" :to="{ name : route.path }" :key="key">
                        {{route.name}}
                    </router-link>
                </li>
                <li class="nav-item" v-if="$auth.check()">
                    <a class="nav-link" href="#" @click.prevent="$auth.logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
  export default {
    data() {
      return {
        routes: {
          // UNLOGGED
          unlogged: [
            {
              name: 'register',
              path: 'register'
            },
            {
              name: 'login',
              path: 'login'
            }
          ],
        }
      }
    },
    mounted() {
      //
    }
  }
</script>