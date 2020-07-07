<template>
  <v-app>
    <v-card
      class="mx-auto"
      width="900px"
      outlined>
      <v-tabs
        v-model="tab"
        background-color="deep-purple accent-4"
        center-active
        grow
        dark>
        <v-tab
          v-for="item in items"
          :key="item.tab">
          {{ item.tab }}
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item
          v-for="item in items"
          :key="item.tab">
          <!-- ログインフォーム -->
          <div v-show="item.tab === 'ログイン'">
            <form @submit.prevent="login">
              <v-text-field
                class="mt-3 ml-10 mr-10"
                v-model="loginForm.email"
                :rules="emailRules"
                label="メールアドレス"
                hide-details="auto"></v-text-field>
              <v-text-field
                class="mt-5 ml-10 mr-10"
                v-model="loginForm.password"
                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                :type="show1 ? 'text' : 'password'"
                label="パスワード"
                counter
                @click:append="show1 = !show1"></v-text-field>

              <button type="submit" class="button button--inverse">login</button>
            </form>
          </div>

          <div v-show="item.tab === '新規登録'">
            あ
          </div>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </v-app>
</template>

<script>
export default {
  data () {
    return {
      tab: null,
      show1: false,
      items: [
        { tab: 'ログイン' },
        { tab: '新規登録' },
      ],
      loginForm: {
        email: '',
        password: '',
      },
      //Validations
      emailRules: [
        v => !!v || 'メールアドレスを入力してください',
        v => /.+@.+\..+/.test(v) || '無効なメールアドレスです',
      ],
    }
  },
  methods: {
    login () {
      console.log(this.loginForm)
    }
  }
}
</script>