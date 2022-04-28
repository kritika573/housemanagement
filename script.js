const house_no = document.getElementById('house_no')
const block_no = document.getElementById('category_id')
const form = document.getElementById('form')
const errorElement = document.getElementById('msg')

form.addEventListener('save', (e) => {
  let messages = []
  if (house_no.value === '' || house_no.value == null) {
    messages.push('House number is required')
  }
  if (block_no.value === '' || block_no.value == null) {
    messages.push('Block number is required')
  }
  if (messages.length > 0) {
    e.preventDefault()
    errorElement.innerText = messages.join(', ')
  }
})