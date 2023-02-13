import { defineStore } from "pinia";
import { useStorage } from "@vueuse/core";

export const useCartStore = defineStore("cart", () => {
  const cart = useStorage("cart", []);

  function setCart(value) {
    cart.value = value;
  }

  function addToCart(item, quantity = 1) {
    console.log("addToCart", item, quantity);
    const itemAlreadyInCart = cart.value.find((i) => i["@id"] === item["@id"]);
    if (itemAlreadyInCart) {
      updateCart(item, itemAlreadyInCart.quantity + quantity);
      return;
    }
    setCart([...cart.value, { ...item, quantity }]);
  }

  function updateCart(item, quantity = 1) {
    console.log("updateCart", item, quantity);
    const itemIndex = cart.value.findIndex((i) => i["@id"] === item["@id"]);
    if (itemIndex === -1) {
      if (quantity <= 0) return;
      setCart([...cart.value, { ...item, quantity }]);
      return;
    }

    if (quantity <= 0) {
      removeFromCart(item);
      return;
    }
    setCart(
      cart.value.map((i) => {
        if (i["@id"] === item["@id"]) {
          return { ...item, quantity };
        }
        return i;
      })
    );
    console.log("cart", cart.value);
  }

  function removeFromCart(item) {
    setCart(cart.value.filter((i) => i["@id"] !== item["@id"]));
  }

  function clearCart() {
    setCart([]);
  }

  return {
    cart,
    addToCart,
    updateCart,
    removeFromCart,
    clearCart,
  };
});
