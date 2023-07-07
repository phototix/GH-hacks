function generateUniqueId() {
  const timestamp = Date.now().toString(36); // Convert timestamp to base36 string
  const randomChars = Math.random().toString(36).substr(2, 5); // Generate random characters
  return timestamp + randomChars;
}

const token = generateUniqueId();
console.log(token);