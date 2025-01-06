export function applyDrag(arr, dragResult) {
  const { removedIndex, addedIndex } = dragResult;
  console.log('applyDrag', { arr, dragResult });

  // If neither removedIndex nor addedIndex are valid, return the array as-is
  if (removedIndex === null || addedIndex === null) return arr;

  const result = [...arr];

  // Perform the swap
  const temp = result[removedIndex];
  result[removedIndex] = result[addedIndex];
  result[addedIndex] = temp;

  console.log('Swapped Result:', result);
  return result;
}
