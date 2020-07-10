<template>
  <v-card
    class="mx-auto mt-10"
    width="830px"
    outlined>
    <v-tabs
      v-model="tab"
      background-color="light-blue darken-2"
      center-active
      grow
      dark>
      <v-tab
        v-for="item in items"
        :key="item.tab"
        class="font-weight-bold">
        {{ item.tab }}
      </v-tab>
    </v-tabs>
    <v-tabs-items v-model="tab">
      <v-tab-item
        v-for="item in items"
        :key="item.tab">
        <!-- ログインフォーム -->
        <div v-show="item.tab === 'ログイン'">
          <LoginForm />
        </div>
        <!-- 新規登録フォーム -->
        <div v-show="item.tab === '新規登録'">
          <RegisterForm />
        </div>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
import LoginForm    from '../components/forms/LoginForm.vue'
import RegisterForm from '../components/forms/RegisterForm.vue'

export default {
  components: {
    LoginForm,
    RegisterForm
  },
  data () {
    return {
      tab: null,
      items: [
        { tab: 'ログイン' },
        { tab: '新規登録' },
      ],
    }
  }
}
</script>