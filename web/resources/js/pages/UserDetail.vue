<template>
  <div>
    <h3>{{ user.name }}のマイページ</h3>
    <div>{{ user.profile.psid }}</div>
    <ProfileForm />
  </div>
</template>

<script>
import ProfileForm from '../components/forms/ProfileForm.vue'

export default {
  props: {
    id: {
      type: String,
      required: true,
    }
  },
  components: {
    ProfileForm
  },
  data () {
    return {
      user: null,
    }
  },
  methods: {
    async userShow () {
      const response = await axios.get(`/api/users/${this.id}`)
      console.log(response)
      this.user = response.data
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.userShow()
      },
      immediate: true
    }
  }
}
</script>