export function formatConstraintViolation({ data }) {
  return data.violations.reduce(
    (accumulator, { propertyPath, message }) => ({
      ...accumulator,
      [propertyPath]: message,
    }),
    {}
  );
}

export function isConstraintViolation(error) {
  return error.data?.["@type"] === "ConstraintViolationList";
}
