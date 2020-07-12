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
          <v-textarea
            class="mt-5 ml-10 mr-10"
            counter
            label="自己紹介"
            v-model="profileForm.content"></v-textarea>
          <v-select
            @change="changePlatForm"
            class="mt-4 ml-10 mr-10"
            :items="['PS4', 'PC']"
            v-model="profileForm.platform"
            label="プラットフォーム"></v-select>
        <!-- PlatFormIDField -->
          <v-text-field
            v-show="ps4Flag"
            class="mt-1 ml-10 mr-10"
            v-model="profileForm.psid"
            label="PSID"
            hide-details="auto"></v-text-field>
          <v-text-field
            v-show="pcFlag"
            class="mt-1 ml-10 mr-10"
            v-model="profileForm.originid"
            label="OriginID"
            hide-details="auto"></v-text-field>
        <!-- / -->
          <div class="mt-5 mb-5 d-flex justify-center">
            <v-btn v-if="!sending" @click="submit" width="255px" class="mb-5" color="primary" dark>完了</v-btn>
            <v-progress-circular
              v-else
              indeterminate
              color="green"
            ></v-progress-circular>
          </div>
        </form>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">閉じる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data () {
    return {
      dialog:   false,
      sending:  false,
      ps4Flag:  false,
      pcFlag:   false,
      errors: '',
      profileForm: {
        content: '',
        platform: '',
        psid: '',
        originid: '',
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
      this.profileForm.originid = ''
      this.profileForm.content = ''
      this.profileForm.platform = ''
    },
    changePlatForm () {
      if (this.profileForm.platform === 'PS4') {
        this.ps4Flag  = true
        this.pcFlag   = false
      } else if (this.profileForm.platform === 'PC') {
        this.pcFlag   = true
        this.ps4Flag  = false
      }
    }
  }
}
</script>