<template>
    <div class="card">
        <div class="card-header">{{ test_case }}</div>

        <div class="card-body" v-if="test_images.length">
          <gallery :images="test_images" :index="index" @close="index = null"></gallery>
          <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-6 thumb" v-for="(image, imageIndex) in test_images" :key="imageIndex">
                <a class="thumbnail" >
                  <img class="img-thumbnail" :src="image.url" style="height: 200px; width: 100%;">
                  <div class="text-right">
                    <small class='text-muted'>{{ image.name }}</small>
                  </div>
                </a>
            </div>
          </div>
        </div>
        <div class="card-body" v-else>
          No Images Found.
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
        computed: {

          test_case: function () {
            return this.selected_test.replace('/',' - ').replace('_',' ').toUpperCase();
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
