<template>
  <div v-if="!loading">
    <div class="d-flex justify-start">
      <div @click.stop="FollowingDialog = true" class="grey--text text--darken-1">{{ this.followingCount }}フォロー中</div>
      <v-divider
        class="mx-4"
        vertical
      ></v-divider>
      <div @click.stop="FollowerDialog = true" class="grey--text text--darken-1">{{ this.followersCount }}フォロワー</div>
    </div>
    <v-dialog v-model="FollowingDialog" max-width="350">
      <v-card>
        <FollowList 
          :list="user.followings"
          @loading="loadingUser" 
        />
      </v-card>
    </v-dialog>
  </div>
  <div v-else>
    <v-overlay :value="overlay">
      <v-text-field color="success" loading disabled></v-text-field>
    </v-overlay>
  </div>
</template>

<script>
import FollowList from '../components/FollowList.vue'

export default {
  props: {
    user: {
      type: Object
    },
    followingCount: {
      type: Number
    },
    followersCount: {
      type: Number
    }
  },
  components: {
    FollowList,
  },
  data () {
    return {
      FollowingDialog: false,
      FollowerDialog: false,
      loading: false,
      overlay: false,
    }
  },
  methods: {
    loadingUser () {
      this.loading = true
      this.overlay = true

      setTimeout(function () {
        this.FollowingDialog = false
        this.FollowerDialog  = false
        this.loading = false
        this.overlay = false
      }.bind(this), 2000);
    }
  }
}
</script>