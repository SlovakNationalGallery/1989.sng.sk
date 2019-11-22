export function initializeJournalTagPopovers() {
  $('body').popover({
    placement: 'bottom',
    trigger: 'focus',
    html: true,
    content: function() {
      const tag = $(this).data('tag');
      const date = $(this).data('date');
      const categories = $(this).data('tag-categories').split(',');
      const url = Router.resolve({
        name: 'journal-entries',
        params: { date },
        query: { filter: tag },
      }).href;

      return `
        <strong>${tag}</strong><br />
        <span>Kategórie: ${categories.join(', ')}</span><br />
        <a href="${url}">Preskúmať heslo</a>
      `;
    },
    title: '',
    selector: '.journal-entry-tag'
  })
}
