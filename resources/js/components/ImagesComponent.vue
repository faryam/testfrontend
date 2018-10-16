<template>
    <div class="card">
        <div class="card-header">{{ test_case }}</div>

        <div class="card-body" v-if="test_images.length">
          <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-6 thumb" v-for="(image, imageIndex) in test_images" :key="imageIndex" v-if="!image.name.includes('_fail')">
                <a class="thumbnail fancybox" rel="ligthbox" :href="image.url" :title="image.name.replace(/-/g,' ').toUpperCase()">
                  <img class="img-thumbnail" :src="image.url" v-bind:style="image_style">
                  <div class="text-center">
                    <small class='text-muted'>{{ image.name.replace(/-/g,' ').toUpperCase() }}</small>
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
            'browser',
        ],
        data: function () {
          return {
            index: null
          }
        },
        computed: {

          test_case: function () {
            return this.selected_test.replace(/-/g,' ').replace('/',' - ').replace(/_/g,' ').toUpperCase();
          },
          image_style:function () {
            if (this.browser!='chrome' && this.browser !='firefox' && this.browser!='safari') {
              return '';
            }
            else
            {
              return  { height: '200px',width: '100%'};
            }
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
