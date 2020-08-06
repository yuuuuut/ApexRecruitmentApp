<template>
  <div>
    <div v-for="n in notifications" :key="n.id">
      {{ n.id }}
      <div v-if="n.action === 'follow'">
        {{ n }}さんにフォローされました
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      notifications: null
    }
  },
  created: function () {
      this.getNotification()
  },
  methods: {
    async getNotification () {
      const response2 = await axios.get(`/api/notification`)
      console.log(response2)

      this.notifications = response2.data
      console.log(this.notifications)
    }
  }
}

</script>