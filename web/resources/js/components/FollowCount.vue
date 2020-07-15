<template>
  <div>
    {{ this.followingCount }}フォロー中
    {{ this.followersCount }}フォロワー
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object
    }
  },
  data () {
    return {
      followingCount: this.user.following_count,
      followersCount: this.user.followers_count,
    }
  },
}
</script>