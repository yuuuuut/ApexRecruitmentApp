<template>
  <form @submit.prevent>
    <!-- ErrorMessage -->
    <div v-if="registerErrors" class="errors">
      <ul v-if="registerErrors.name">
        <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
      </ul>
      <ul v-if="registerErrors.email">
        <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
      </ul>
      <ul v-if="registerErrors.password">
        <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
      </ul>
    </div>
    <!-- / -->
    <v-text-field
      class="mt-5 ml-10 mr-10"
      v-model="registerForm.name"
      label="名前 (例: コブラツイスト山中)"
      :rules="nameRules"
      hide-details="auto"></v-text-field>
    <v-text-field
      class="mt-5 ml-10 mr-10"
      v-model="registerForm.email"
      label="メールアドレス"
      :rules="emailRules"
      hide-details="auto"></v-text-field>
    <v-text-field
      class="mt-5 ml-10 mr-10"
      v-model="registerForm.password"
      :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
      :type="show1 ? 'text' : 'password'"
      label="パスワード"
      :rules="passRules"
      counter
      @click:append="show1 = !show1"></v-text-field>
    <v-text-field
      class="mt-2 ml-10 mr-10"
      v-model="registerForm.password_confirmation"
      :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
      :type="show2 ? 'text' : 'password'"
      label="パスワード(確認)"
      :rules="passRules"
      counter
      @click:append="show2 = !show2"></v-text-field>
    <div class="mt-3 mb-5 d-flex justify-center">
      <v-btn @click="register" width="300px" class="mb-5" color="primary" dark>新規登録</v-btn>
    </div>
  </form>
</template>

<script>
import { mapState } from 'vuex'

export default {
  data () {
    return {
      show1: false,
      show2: false,
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      //Validations
      nameRules: [
        v => !!v || '名前を入力してください',
      ],
      emailRules: [
        v => !!v || 'メールアドレスを入力してください',
        v => /.+@.+\..+/.test(v) || '無効なメールアドレスです',
      ],
      passRules: [
        v => !!v || 'パスワードを入力してください',
        v => v.length >= 8 || '8文字以上設定してください'
      ],
    }
  },
  computed:  {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      registerErrors: state => state.auth.registerErrorMessages
    })
  },
  created () {
    this.clearError()
  },
  methods: {
    async register () {
      await this.$store.dispatch('auth/register', this.registerForm)
      
      if (this.apiStatus) {
        this.$router.push('/')
      }
    },
    clearError () {
      this.$store.commit('auth/setRegisterErrorMessages', null)
    }
  }
}
</script>