<template>
  <div>
    <h1>Show Book {{ item && item['@id'] }}</h1>

    <div
      v-if="isLoading"
      class="alert alert-info"
      role="status">Loading...</div>
    <div
      v-if="error"
      class="alert alert-danger"
      role="alert">
      <span
        class="fa fa-exclamation-triangle"
        aria-hidden="true">{{ error }}</span>
    </div>
    <div
      v-if="deleteError"
      class="alert alert-danger"
      role="alert">
      <span
        class="fa fa-exclamation-triangle"
        aria-hidden="true">{{ deleteError }}</span>
    </div>
    <div
      v-if="item"
      class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Field</th>
            <th>Value</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">isbn</th>
            <td>{{ item['isbn'] }}</td>
          </tr>
          <tr>
            <th scope="row">title</th>
            <td>{{ item['title'] }}</td>
          </tr>
          <tr>
            <th scope="row">description</th>
            <td>{{ item['description'] }}</td>
          </tr>
          <tr>
            <th scope="row">author</th>
            <td>{{ item['author'] }}</td>
          </tr>
          <tr>
            <th scope="row">publicationDate</th>
            <td>{{ item['publicationDate'] }}</td>
          </tr>
          <tr>
            <th scope="row">reviews</th>
            <td>{{ item['reviews'] }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <router-link
      :to="{ name: 'BookList' }"
      class="btn btn-primary">
      Back to list
    </router-link>
    <router-link
      v-if="item"
      :to="{ name: 'BookUpdate', params: { id: item['@id'] } }"
      class="btn btn-warning">
      Edit
    </router-link>
    <button
      class="btn btn-danger"
      @click="del">Delete</button>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import { mapFields } from 'vuex-map-fields';
import ItemWatcher from '../../mixins/ItemWatcher';
import * as types from '../../store/modules/book/show/mutation_types';
import * as delTypes from '../../store/modules/book/delete/mutation_types';

export default {
  mixins: [ItemWatcher],
  computed: {
    ...mapFields('book/del', {
      deleteError: 'error',
      deleted: 'deleted',
      mercureDeleted: 'mercureDeleted',
    }),
    ...mapFields('book/show', {
      error: 'error',
      isLoading: 'isLoading',
      item: 'retrieved',
      hubUrl: 'hubUrl',
    }),
    itemUpdateMutation: () =>`book/show/${types.BOOK_SHOW_SET_RETRIEVED}`,
    itemMercureDeletedMutation: () => `book/del/${delTypes.BOOK_DELETE_MERCURE_SET_DELETED}`,
  },

  watch: {
    // eslint-disable-next-line object-shorthand,func-names
    deleted: function(deleted) {
      if (!deleted) {
        return;
      }

      this.$router.push({ name: 'BookList' });
    },
    // eslint-disable-next-line object-shorthand,func-names
    mercureDeleted: function(deleted) {
      if (!deleted) {
        return;
      }

      this.$router.push({ name: 'BookList' });
    },
  },

  beforeDestroy () {
    this.reset();
  },

  created () {
    this.retrieve(decodeURIComponent(this.$route.params.id));
  },

  methods: {
    ...mapActions({
      deleteItem: 'book/del/del',
      reset: 'book/show/reset',
      retrieve: 'book/show/retrieve',
    }),

    del() {
      if (window.confirm('Are you sure you want to delete this book?')) {
        this.deleteItem(this.item);
      }
    },
  },
};
</script>
