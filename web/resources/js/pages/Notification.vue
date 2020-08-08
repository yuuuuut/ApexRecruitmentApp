<template>
  <div class="mt-5">
    <div
      v-for="n in notifications"
      :key="n.id"
    >
      <v-card
        class="mx-auto mb-3"
        width="600px"
        outlined
      >
        <v-card-text>
          <div v-if="n.action === 'follow'">
            <router-link
              :to="{ name: 'userDetail', params: { id: n.visiter.id.toString() }}" 
              class="grey--text text--darken-3"
              style="text-decoration: none;"
            >
              {{ n.visiter.name }}さんにフォローされました
            </router-link>
          </div>
        </v-card-text>
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      notifications: []
    }
  },
  methods: {
    async getNotification () {
      const response = await axios.get(`/api/notification`)

      this.notifications = response.data
      console.log(this.notifications)
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.getNotification()
      },
      immediate: true
    }
  }
}

</script>