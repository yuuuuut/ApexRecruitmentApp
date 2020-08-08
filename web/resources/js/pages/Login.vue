<template>
  <div v-if="load">
    <v-card
      class="mx-auto mt-10"
      width="830px"
      elevation="10"
      tile
    >
      <v-tabs
        v-model="tab"
        background-color="cyan "
        center-active
        grow
        dark
      >
        <v-tab
          v-for="item in items"
          :key="item.tab"
          class="font-weight-bold"
        >
          {{ item.tab }}
        </v-tab>
      </v-tabs>
      <v-tabs-items v-model="tab">
        <v-tab-item
          v-for="item in items"
          :key="item.tab"
        >
          <!-- ログインフォーム -->
          <div v-show="item.tab === 'ログイン'">
            <LoginForm
              @load="loading"
            />
          </div>
          <!-- 新規登録フォーム -->
          <div v-show="item.tab === '新規登録'">
            <RegisterForm />
          </div>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </div>
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
      load: true,
      tab: null,
      items: [
        { tab: 'ログイン' },
        { tab: '新規登録' },
      ],
    }
  },
  methods: {
    loading () {
      this.load = false
    }
  }
}
</script>