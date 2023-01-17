<template>
  <form @submit.prevent="handleSubmit(item)">
    <div class="form-group">
      <label
        for="book_isbn"
        class="form-control-label">isbn</label>
        <input
          id="book_isbn"
          v-model="item.isbn"
          :class="['form-control', !isValid('isbn') ? 'is-invalid' : 'is-valid']"
          type="text"
          placeholder="The ISBN of the book.">
      <div
        v-if="!isValid('isbn')"
        class="invalid-feedback">{{ violations.isbn }}</div>
    </div>
    <div class="form-group">
      <label
        for="book_title"
        class="form-control-label">title</label>
        <input
          id="book_title"
          v-model="item.title"
          :class="['form-control', !isValid('title') ? 'is-invalid' : 'is-valid']"
          type="text"
          required="required"
          placeholder="The title of the book.">
      <div
        v-if="!isValid('title')"
        class="invalid-feedback">{{ violations.title }}</div>
    </div>
    <div class="form-group">
      <label
        for="book_description"
        class="form-control-label">description</label>
        <input
          id="book_description"
          v-model="item.description"
          :class="['form-control', !isValid('description') ? 'is-invalid' : 'is-valid']"
          type="text"
          required="required"
          placeholder="A description of the item.">
      <div
        v-if="!isValid('description')"
        class="invalid-feedback">{{ violations.description }}</div>
    </div>
    <div class="form-group">
      <label
        for="book_author"
        class="form-control-label">author</label>
        <input
          id="book_author"
          v-model="item.author"
          :class="['form-control', !isValid('author') ? 'is-invalid' : 'is-valid']"
          type="text"
          required="required"
          placeholder="The author of this content or rating. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.">
      <div
        v-if="!isValid('author')"
        class="invalid-feedback">{{ violations.author }}</div>
    </div>
    <div class="form-group">
      <label
        for="book_publicationDate"
        class="form-control-label">publicationDate</label>
        <input
          id="book_publicationDate"
          v-model="item.publicationDate"
          :class="['form-control', !isValid('publicationDate') ? 'is-invalid' : 'is-valid']"
          type="dateTime"
          required="required"
          placeholder="The date on which the CreativeWork was created or the item was added to a DataFeed.">
      <div
        v-if="!isValid('publicationDate')"
        class="invalid-feedback">{{ violations.publicationDate }}</div>
    </div>
    <div class="form-group">
      <label
        for="book_reviews"
        class="form-control-label">reviews</label>
        <input
          id="book_reviews"
          v-model="item.reviews"
          :class="['form-control', !isValid('reviews') ? 'is-invalid' : 'is-valid']"
          type="text"
          placeholder="The book's reviews.">
      <div
        v-if="!isValid('reviews')"
        class="invalid-feedback">{{ violations.reviews }}</div>
    </div>

    <button
      type="submit"
      class="btn btn-success">Submit</button>
  </form>
</template>

<script>
  import { find, get, isUndefined } from 'lodash';
  import { mapActions } from 'vuex';

  export default {
  props: {
    handleSubmit: {
      type: Function,
      required: true,
    },

    values: {
      type: Object,
      required: true,
    },

    errors: {
      type: Object,
      default: () => {},
    },

    initialValues: {
      type: Object,
      default: () => {},
    }
  },

  mounted() {
  },

  computed: {

    // eslint-disable-next-line
    item() {
      return this.initialValues || this.values;
    },

    violations() {
      return this.errors || {};
    },
  },

  methods: {
    ...mapActions({
    }),

    isSelected(collection, id) {
      return find(this.item[collection], ['@id', id]) !== undefined;
    },

    isValid(key) {
      return isUndefined(get(this.violations, key));
    },
  },
};
</script>
