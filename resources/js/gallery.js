import Vue from 'vue';
import ImageUpload from './components/ImageUpload';
import GalleryUpload from './components/GalleryUpload';

const app = new Vue({
  el: '#vue',
  components: {
    ImageUpload,
    GalleryUpload,
  },
});
