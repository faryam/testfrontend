<template>
    <div class="card">
        <div class="card-header">{{ selected_test }}</div>

        <div class="card-body">
            <gallery :images="test_images" :index="index" @close="index = null"></gallery>
            <a class="image" v-for="(image, imageIndex) in test_images" :key="imageIndex">
                <img :src="image" :style="{ width: '300px', height: '200px' }">
            </a>
        </div>
    </div>
</template>

<script>
    import VueGallery from 'vue-gallery';
    export default {
        props: [
            'test_images',
            'selected_test',
        ],
        data: function () {
          return {
            index: null
          }
        },
        components: {
          'gallery': VueGallery
      },
    }
</script>
<style scoped>
  .image {
    border: 1px solid #ebebeb;
    margin: 5px;
  }
</style> 
