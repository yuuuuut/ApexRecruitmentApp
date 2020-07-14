<template>
  <div>
    <button type="button" class="btn btn-point btn-raised" @click="unfollow">
      unfollow
    </button>
    <button type="button" class="btn btn-default btn-raised" @click="follow">
      follow
    </button>
  </div>
</template>

<script>
export default {
  props: {
    userId: {
      type: Number,
    }
  },
  data () {
    return {
      sending: false,
    }
  },
  methods: {
    async follow () {
      this.sending = true

      const response = await axios.post(`/api/follow/${this.userId}`)
      console.log(response)
      this.sending = false
    },
    async unfollow () {
      this.sending = true

      const response = await axios.delete(`/api/unfollow/${this.userId}`)
      console.log(response)
      this.sending = false
    }
  }
}
</script>