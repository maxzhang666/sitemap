import app from 'flarum/admin/app';
import SitemapSettingsPage from './components/SitemapSettingsPage';

app.initializers.add('maxzhang/sitemap', () => {
  app.extensionData.for('maxzhang-sitemap').registerPage(SitemapSettingsPage);
});
