<template>
  <div>
    <div class="d-flex justify-start">
      {{ this.followingCount }}フォロー中
      {{ this.followersCount }}フォロワー
    </div>
  </div>
</template>

<script>
export default {
  props: {
    followingCount: {
      type: Number
    },
    followersCount: {
      type: Number
    }
  },
}
</script>