<template>
  <div>
  <h1>Tets</h1>

  <form @submit.prevent>
    <v-text-field
      v-model="profileForm.psid"
      class="mt-5 ml-10 mr-10"
      hide-details="auto"></v-text-field>
    <v-text-field
      v-model="profileForm.content"
      class="mt-5 ml-10 mr-10"
      hide-details="auto"></v-text-field>
    <v-text-field
      v-model="profileForm.platform"
      class="mt-5 ml-10 mr-10"
      hide-details="auto"></v-text-field>
    <div class="mt-3 mb-5 d-flex justify-center">
      <v-btn v-if="!sending" @click="submit" width="300px" class="mb-5" color="primary" dark>完了</v-btn>
      <v-progress-circular
        v-else
        indeterminate
        color="green"
      ></v-progress-circular>
    </div>
  </form>
  </div>
</template>

<script>
export default {
  data () {
    return {
      sending: false,
      profileForm: {
        psid: '',
        content: '',
        platform: '',
      }
    }
  },
  methods: {
    async submit () {
      if (this.sending) {
        return
      }
      this.sending = true
      const data = await axios.post('/api/profiles', this.profileForm)
      this.resetValue()
      console.log(data)
      this.sending = false
    },
    resetValue () {
      this.profileForm.psid = ''
      this.profileForm.content = ''
      this.profileForm.platform = ''
    }
  }
}
</script>