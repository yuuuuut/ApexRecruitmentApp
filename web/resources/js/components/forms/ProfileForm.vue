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
      <v-btn @click="submit" width="300px" class="mb-5" color="primary" dark>新規登録</v-btn>
    </div>
  </form>
  </div>
</template>

<script>
export default {
  data () {
    return {
      profileForm: {
        psid: '',
        content: '',
        platform: '',
      }
    }
  },
  methods: {
    async submit () {
      const data = await axios.post('/api/profiles', this.profileForm)
      console.log(data)
    }
  }
}
</script>