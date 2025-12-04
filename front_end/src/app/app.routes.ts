import { Routes } from '@angular/router';
// import { CampaignList } from './components/user/campaign-list/campaign-list';
// import { BranchesList } from './components/user/branch-list/branch-list';
// import { CampaignDetail } from './components/user/campaign-detail/campaign-detail';
import { BranchComponent } from './components/user/branch/branch';
import { BranchesList } from './components/user/branch-list/branch-list';

export const routes: Routes = [
 { path: '', redirectTo: '', pathMatch: 'full' },
{ path: ':slug', component: BranchesList },
  { path: ':slug/:branchSlug', component: BranchComponent }, 
   // { path: 'product/:id', component: CampaignDetail },
      // { path: 'campaigns/:adId', component: CampaignList },
  // { path: ':adId', component: CampaignList },

];
