<template>
  <div>
    <p>aaa</p>
    {{ this.id }}
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      post: null
    }
  },
  methods: {
    async getPost () {
      const response = await axios.get(`api/posts/${this.id}`)
      console.log(response)

      if (response.status !== 200) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.post = response.data
    }
  }
}
</script>