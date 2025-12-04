export interface Vendor {
  id: string;
  type: string;
  name: string;
  description?: string;
  branch?: string;
  link?: string;
  phone?: string;
  locationLink?: string;
  instagramLink?: string;
  whatsapp?: string;
  facebook?: string;
  snapchat?: string;
  image: string | string[];
  imageUrls: string[];
  campaigns: Campaign[];
  details: Detail[];
}

export interface Campaign {
  id: string;
  name: string;
  company_id: string;
  start_date: string;
  end_date: string;
  amount_per_day: number;
  product_ids: string[];
  products?: Product[];
  type?: string;
  company_theme?: string;
  company?: Company;
  url?: string; 
  has_branch?: boolean; 
  has_product?: boolean; 
  branches?: any[]; 
  cats: string[]; 
}

export interface CampaignStats {
  date: string;
  visits: number;
  callClicks: number;
  whatsappClicks: number;
  instagramClicks: number;
  facebookClicks: number;
  snapchatClicks: number;
}
export interface Branch {
  id: string;
  name?: string;
  phone?: string;
  whatsapp?: string;
  google_Map?: string[];
  instagram?: string;
  facebook?: string;
  snapchat?: string;
  galleryImages?: string[];
  servicesImages?:string[];
  location?: string; // إضافة موقع
  unit_type: string[];  
  unitPrice: number[]; 
  slug?:string;
  description?: string; // إضافة وصف
}

export interface Product {
  id: string;
  name: string;
  catgory_name: string;
  company_name: string;
  whatsapp?: string;
  facebook?: string;
  instagram?: string;
  phone?: string;
  snapchat?: string;
  image: string | string[];
  images?: string[];
  description?: string;
  details?: Detail[];
}

export interface Company {
  id: number;
  name: string;
  url: string | null;
  description: string | null;
  logo: string | null;
  phone: string | null;
  company_theme: string | null;
}

export interface Detail {
  id?: number;
  product_id: number;
  ads_id: number;
  date: string;
  type: 'whatsapp' | 'phone' | 'facebook' | 'instagram' | 'snapchat' | 'website';
  count?: number;
  created_at?: string;
  updated_at?: string;
}