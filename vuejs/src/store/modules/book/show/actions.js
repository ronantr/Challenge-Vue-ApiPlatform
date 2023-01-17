import fetch from "../../../../utils/fetch";
import { extractHubURL } from "../../../../utils/mercure";
import * as types from "./mutation_types";

export const retrieve = ({ commit }, id) => {
  commit(types.BOOK_SHOW_TOGGLE_LOADING);

  return fetch(id)
    .then((response) =>
      response.json().then((data) => ({
        data,
        hubUrl: extractHubURL(response),
      }))
    )
    .then(({ data, hubUrl }) => {
      commit(types.BOOK_SHOW_TOGGLE_LOADING);
      commit(types.BOOK_SHOW_SET_RETRIEVED, data);
      if (hubUrl) {
        commit(types.BOOK_SHOW_SET_HUB_URL, hubUrl);
      }
    })
    .catch((e) => {
      commit(types.BOOK_SHOW_TOGGLE_LOADING);
      commit(types.BOOK_SHOW_SET_ERROR, e.message);
    });
};

export const reset = ({ commit }) => {
  commit(types.BOOK_SHOW_RESET);
};
