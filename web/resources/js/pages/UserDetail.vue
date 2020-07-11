<template>
  <h1>Photo Detail</h1>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      required: true,
    }
  },
  data () {
    return {
      user: null
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