<template>
  <div>
    <form action="POST" @submit.prevent="submit">
      <input type="hidden" name="_token" :value="csrf">
      <input type="hidden" name="gallery" :value="gallery">
      <div :class="rowClass">
        <div :class="itemClass" v-for="(image, i) in images" :key="i">
          <image-upload :upload-id="i.toString()" @changePrivacy="changePrivacy" @image="onImage" @removeImage="removeImg"></image-upload>
        </div>
      </div>
      <button @click.prevent="addMore(addAmount)" class="btn btn-link text-center">Meer foto's uploaden</button>
      <button type="submit">Toevoegen</button>
      <div v-if="loading">loading...</div>
    </form>
  </div>
</template>

<script>
import ImageUpload from './ImageUpload';

export default {
  props: {
    initial: {
      type: Number,
      default: 3,
    },
    rowClass: {
      type: String,
      default: 'row',
    },
    itemClass: {
      type: String,
      default: 'col-12 col-md-6 col-xl-4',
    },
    addAmount: {
      type: Number,
      default: 3,
    },
    gallery: {
      type: String,
      default: 'asd',
    }
  },
  computed: {
    csrf: function() {
      return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
  },
  beforeMount: function() {
    this.addMore(this.initial);
  },
  data: () => ({
    images: [],
    loading: false,
  }),
  components: {
    ImageUpload,
  },
  methods: {
    addMore: function(add) {
      const l = this.images.length;
      for (let i = l; i < l + add; i++) {
        this.images.push({});
      }
    },
    submit: function() {
      this.loading = true;
      this.images.forEach(image => {
        const body = new FormData();
        body.append('image', image.file);
        body.append('is_private', image.isPrivate);
        body.append('gallery', this.gallery);

        fetch('/api/pictures', {
          headers: {
            "Accept": "application/json, text-plain, */*",
            // TODO: Move (put in localstorage?)
            "Authorization": `Bearer lpzybXqnYAt69JOCqn798gSRP6d70whmNDffRQswJFiCavLyUidI5J5WF3vq`,
          },
          // Method of PATCH breaks the request????????????????????????????????????????????????????????? bye 5 hours
          method: 'POST',
          body: body,
        })
        .then(response => response.ok ? response.json() : console.error(response))
        .then(data => {
          console.log(data);
        })
        .catch(console.error)
        .finally(() => this.loading = false);
      });
    },
    removeImg: function(id) {
      this.images[id] = undefined;
    },
    onImage: function({ file, id, isPrivate }) {
      this.images[id] = {file, isPrivate};
    },
    changePrivacy({id, val}) {
      this.images[id].isPrivate = val;
    },
  },
}
</script>

<style scoped>

</style>
