import "vue-toastification/dist/index.css";
import Toast, { POSITION } from "vue-toastification";

const options = {
  position: POSITION.BOTTOM_RIGHT,
  maxToasts: 3,
  timeout: 3000,
  hideProgressBar: true,
  pauseOnFocusLoss: false,
  filterBeforeCreate: (toast, toasts) => {
    const isDuplicate = toasts.some(({ content }) => toast.content === content);

    if (isDuplicate) {
      return false;
    }

    return toast;
  },
};

export const toast = {
  install(app) {
    app.use(Toast, options);
  },
};
