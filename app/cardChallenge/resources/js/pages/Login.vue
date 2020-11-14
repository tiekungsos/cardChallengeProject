<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">Login To Game</div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="has_error">
                    <p>{{message}}</p>
                </div>
                <form autocomplete="off" @submit.prevent="login" method="post">
                    <div class="form-group">
                        <label for="name">Username</label>
                        <input type="text" id="name" class="form-control" placeholder="tommy" v-model="name" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" v-model="password" required>
                    </div>
                    <button type="submit" class="btn btn-default">Login</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        name: null,
        password: null,
        has_error: false,
        message : ''
      }
    },
    mounted() {
      //
    },
    methods: {
      login() {
        // get the redirect object
        var redirect = this.$auth.redirect()
        var app = this
        this.$auth.login({
          params: {
            name: app.name,
            password: app.password
          },
          success: function(res) {
             // handle redirection
            const redirectTo = redirect ? redirect.from.name : 'play'
            this.$router.push({name: redirectTo})
          },
          error: function(data) {
              console.log(data);
            this.has_error = true
            this.message = 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง'
          },
          rememberMe: true,
          fetchUser: true
        })
      }
    }
  }
</script>