<template>
  <div class="row">
    <header-card-one />
    <header-card-two />
    <header-card-three />
  </div>
</template>

<script>
import HeaderCardOne from "./_part/HeaderCardOne.vue"
import HeaderCardTwo from "./_part/HeaderCardTwo.vue"
import HeaderCardThree from "./_part/HeaderCardThree.vue"
export default {
  name: "Header",
  components: {
    HeaderCardOne,
    HeaderCardTwo,
    HeaderCardThree,
  },
};
</script>