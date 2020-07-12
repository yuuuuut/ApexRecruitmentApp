<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" dark v-bind="attrs" v-on="on">Profile編集</v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">マイプロフィール</span>
        </v-card-title>
        <form @submit.prevent>
          <!-- Error -->
          <div v-if="errors.length != 0">
            <div v-if="errors.psid">
              <div v-for="e in errors.psid" :key="e">{{ e }}</div>
            </div>
            <div v-if="errors.content">
              <div v-for="e in errors.content" :key="e">{{ e }}</div>
            </div>
          </div>
          <!-- / -->
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

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data () {
    return {
      dialog: false,
      sending: false,
      errors: '',
      profileForm: {
        psid: '',
        content: '',
        platform: '',
      }
    }
  },
  methods: {
    async submit () {
      this.sending = true
      const response = await axios.post('/api/profiles', this.profileForm)
      console.log(response.data)

      if (response.status === 422) {
        this.errors = response.data.errors;
        this.sending = false
        return false
      }

      this.resetValue()
      this.sending = false
      this.dialog  = false
    },
    resetValue () {
      this.profileForm.psid = ''
      this.profileForm.content = ''
      this.profileForm.platform = ''
    }
  }
}
</script>