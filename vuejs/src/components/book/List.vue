<template>
  <div>
    <h1>Book List</h1>

    <div
      v-if="isLoading"
      class="alert alert-info">Loading...</div>
    <div
      v-if="deletedItem"
      class="alert alert-success">{{ deletedItem['@id'] }} deleted.</div>
    <div
      v-if="mercureDeletedItem"
      class="alert alert-success">{{ mercureDeletedItem['@id'] }} deleted by another user.</div>
    <div
      v-if="error"
      class="alert alert-danger">{{ error }}</div>

    <p>
      <router-link
        :to="{ name: 'BookCreate' }"
        class="btn btn-primary">Create</router-link>
    </p>

    <table class="table table-responsive table-striped table-hover">
      <thead>
        <tr>
          <th>id</th>
          <th>isbn</th>
          <th>title</th>
          <th>description</th>
          <th>author</th>
          <th>publicationDate</th>
          <th>reviews</th>
          <th colspan="2"></th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in items"
          :key="item['@id']">
          <th scope="row">
            <router-link
              v-if="item"
              :to="{name: 'BookShow', params: { id: item['@id'] }}">
              {{ item['@id'] }}
            </router-link>
          </th>
        <td>
            {{ item['isbn'] }}
        </td>
        <td>
            {{ item['title'] }}
        </td>
        <td>
            {{ item['description'] }}
        </td>
        <td>
            {{ item['author'] }}
        </td>
        <td>
            {{ item['publicationDate'] }}
        </td>
        <td>
            {{ item['reviews'] }}
        </td>
          <td>
            <router-link
              :to="{name: 'BookShow', params: { id: item['@id'] }}">
              <span
                class="fa fa-search"
                aria-hidden="true"></span>
              <span class="sr-only">Show</span>
            </router-link>
          </td>
          <td>
            <router-link :to="{name: 'BookUpdate', params: { id: item['@id'] }}">
              <span
                class="fa fa-pencil"
                aria-hidden="true"></span>
              <span class="sr-only">Edit</span>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>

    <nav aria-label="Page navigation" v-if="view">
      <router-link
        :to="view['hydra:first'] ? view['hydra:first'] : 'BookContactList'"
        :class="{ disabled: !view['hydra:previous'] }"
        class="btn btn-primary"
        aria-label="First page">
        <span aria-hidden="true">&lArr;</span> First
      </router-link>
      &nbsp;
      <router-link
        :to="!view['hydra:previous'] || view['hydra:previous'] === view['hydra:first'] ? 'BookList' : view['hydra:previous']"
        :class="{ disabled: !view['hydra:previous'] }"
        class="btn btn-primary"
        aria-label="Previous page">
        <span aria-hidden="true">&larr;</span> Previous
      </router-link>

      <router-link
        :to="view['hydra:next'] ? view['hydra:next'] : '#'"
        :class="{ disabled: !view['hydra:next'] }"
        class="btn btn-primary"
        aria-label="Next page">
        Next <span aria-hidden="true">&rarr;</span>
      </router-link>

      <router-link
        :to="view['hydra:last'] ? view['hydra:last'] : '#'"
        :class="{ disabled: !view['hydra:next'] }"
        class="btn btn-primary"
        aria-label="Last page">
        Last <span aria-hidden="true">&rArr;</span>
      </router-link>
    </nav>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import { mapFields } from 'vuex-map-fields';
import ListWatcher from '../../mixins/ListWatcher';
import * as types from '../../store/modules/book/list/mutation_types'
import * as delTypes from '../../store/modules/book/delete/mutation_types';

export default {
  mixins: [ListWatcher],
  computed: {
      ...mapFields('book/del', {
          deletedItem: 'deleted',
          mercureDeletedItem: 'mercureDeleted',
      }),
      ...mapFields('book/list', {
          error: 'error',
          items: 'items',
          hubUrl: 'hubUrl',
          isLoading: 'isLoading',
          view: 'view',
      }),
      itemUpdateMutation: () => `book/list/${types.UPDATE_ITEM}`,
      itemDeleteMutation: () => `book/list/${types.DELETE_ITEM}`,
      itemMercureDeletedMutation: () => `book/del/${delTypes.BOOK_DELETE_MERCURE_SET_DELETED}`,
  },

  mounted() {
    this.getPage();
  },

  methods: {
    ...mapActions({
      getPage: 'book/list/default',
    }),
  },
};
</script>
