#include <gl.h>
#include <glu.h>
#include <glut.h>
#include <glaux.h>
#include <stdio.h>
#include <stdlib.h>
#include <math.h>

#define random(m) (float)rand()*m/RAND_MAX
int scena;

     GLfloat light_ambient[]={0.0,0.0,0.0,1.0};
     GLfloat light_diffuse[]={1.0,1.0,1.0,1.0};
     GLfloat light_specular[]={1.0,1.0,1.0,1.0};
     GLfloat light_position[]={-2.0,2.0,1.0,1.0};

void InitLight(void)
{
     glLightfv(GL_LIGHT0,GL_AMBIENT,light_ambient);
     glLightfv(GL_LIGHT0,GL_DIFFUSE,light_diffuse);
     glLightfv(GL_LIGHT0,GL_SPECULAR,light_specular);
     glLightfv(GL_LIGHT0,GL_POSITION,light_position);
     
     glEnable(GL_LIGHTING);
     glEnable(GL_LIGHT0);     
}

//////////////////////
//  SCENA NUMBER 1  //
//////////////////////
const int s1_n=100;
int s1_p=0;
int s1_t=0;

float s1_a1=0.0001,s1_a2=0.00007,s1_k1=1.5,s1_k2=2.3,s1_dvx=0,s1_dvy=0,s1_dvz=0,s1_r;
float s1_x[s1_n],s1_y[s1_n],s1_z[s1_n],s1_vx[s1_n],s1_vy[s1_n],s1_vz[s1_n];

float s1_mat1_diff[]={0.5f,0.5f,0.7f};
float s1_mat1_amb[]={0.6,0.5,0.8};
float s1_mat1_spec[]={0.7f,0.6f,0.5f};
float s1_mat1_shininess=0.7*128;

float dist(int i,int j)
{
      return sqrt( (s1_x[i]-s1_x[j])*(s1_x[i]-s1_x[j])+
      (s1_y[i]-s1_y[j])*(s1_y[i]-s1_y[j])+(s1_z[i]-s1_z[j])*(s1_z[i]-s1_z[j]));
}

void init1()
{
     glClearColor(0.0f, 0.0f, 0.0f, 0.0f);
     glClearDepth(1.0);

     glEnable(GL_LIGHTING);
     glEnable(GL_LIGHT0);
     glEnable(GL_DEPTH_TEST);
     glDisable(GL_TEXTURE_2D);
     //random
     int i;
     for (i=0;i<s1_n;i++)
         {
                      s1_x[i]=random(4)-2;
                      s1_y[i]=random(4)-2;
                      s1_z[i]=random(4)-2;
                      s1_vx[i]=0;s1_vy[i]=0;s1_vz[i]=0;
         }
}
     
void DrawI1(int i)
{
     glTranslatef(s1_x[i],s1_y[i],s1_z[i]);
     glutSolidSphere(0.04,11,11);
     glTranslatef(-s1_x[i],-s1_y[i],-s1_z[i]);
}

void display1(void)
{    
     int i=0;
     glClear(GL_COLOR_BUFFER_BIT|GL_DEPTH_BUFFER_BIT);
     glPushMatrix();
         
     glMaterialfv(GL_FRONT,GL_AMBIENT,s1_mat1_amb);
     glMaterialfv(GL_FRONT,GL_DIFFUSE,s1_mat1_diff);
     glMaterialfv(GL_FRONT,GL_SPECULAR,s1_mat1_spec);
     glMaterialf(GL_FRONT,GL_SHININESS,s1_mat1_shininess);
     
     for(i=0;i<s1_n;i++)
     {
                     s1_vx[i]+=s1_dvx;s1_vy[i]+=s1_dvy;s1_vz[i]+=s1_dvz;
                     s1_x[i]+=s1_vx[i];s1_y[i]+=s1_vy[i];s1_z[i]+=s1_vz[i];
                     
                     if ((s1_x[i]>2)||(s1_x[i]<-2)) s1_vx[i]=-s1_vx[i];
                     if ((s1_y[i]>2)||(s1_y[i]<-2)) s1_vy[i]=-s1_vy[i];
                     if ((s1_z[i]>2)||(s1_z[i]<-2)) s1_vz[i]=-s1_vz[i];
                     
                     DrawI1(i);
                     s1_dvx=0;s1_dvy=0;s1_dvz=0;
                     
                     for (int j=0;j<s1_n;j++) if (j!=i)
                     {
                         s1_r=dist(i,j);
                         s1_dvx+=(s1_a1*pow(s1_r,-s1_k1)-s1_a2*pow(s1_r,-s1_k2))*(s1_x[j]-s1_x[i])/s1_r;
                         s1_dvy+=(s1_a1*pow(s1_r,-s1_k1)-s1_a2*pow(s1_r,-s1_k2))*(s1_y[j]-s1_y[i])/s1_r;
                         s1_dvz+=(s1_a1*pow(s1_r,-s1_k1)-s1_a2*pow(s1_r,-s1_k2))*(s1_z[j]-s1_z[i])/s1_r;
                     }
     }
     
     glPopMatrix();
     
     glPopMatrix();
     glFlush();
     glutSwapBuffers();
}

void reshape1(int w,int h)
{
     glViewport(0,0,(GLsizei)w,(GLsizei)h);
     glMatrixMode(GL_PROJECTION);
     glLoadIdentity();
     
     gluPerspective(40.0,(GLfloat)w/h,1,100.0);
     glMatrixMode(GL_MODELVIEW);
     
     glLoadIdentity();
     gluLookAt(0.0f,0.0f,8.0f,
     0.0f,0.0f,0.0f,
     0.0f,1.0f,0.0f);
}

void redraw1()
{
     for (s1_p=0;s1_p<30000000;s1_p++) s1_p=s1_p;
     glutPostRedisplay();
}

//////////////////////
//  SCENA NUMBER 2  //
//////////////////////

float s2_mat1_dif[]={0.8f, 0.8f,0.0f};
float s2_mat1_amb[]={0.2f,0.2f,0.2f};
float s2_mat1_spec[]={0.6f,0.6f,0.6f};
float s2_mat1_shininess=0.5f*128;
const float s2_alpha=0.1;

float s2_r=0.4,s2_t=M_PI/2;
float s2_k;
const int s2_count=60;
float s2_fi=2*M_PI/s2_count;
float s2_rx=-40,s2_ry=0,s2_rz=50;

float ka(float t)
{
      float res=(0.5+s2_alpha)*sin(t)+0.5;
      if (res<0) return 0;
      if (res>1) return 1;
      return res;
}

float zn(float x)
{
    if ((x>=0)&&(x<=4))return -3+x;
    if ((x>=-4)&&(x<=0)) return 3+x;
}

float fnc(float x,float k)
{
if (1-k*zn(x)*zn(x)>0) return sqrt(1-k*zn(x)*zn(x));
return 0;
}

int sg(float x,float k)
{
    if ((x>=1)&&(x<=3))return 1;
    if ((x>=-1)&&(x<=1)) return -1;
    if ((x>=-3)&&(x<=-1)) return 1;
    return 1;
}

void init2(void)
{
     glClear(GL_COLOR_BUFFER_BIT|GL_DEPTH_BUFFER_BIT);
     glEnable(GL_DEPTH_TEST); 
     glDisable(GL_TEXTURE_2D);    
     s2_k=ka(s2_t);

     glEnable(GL_LIGHTING);
     glEnable(GL_LIGHT0);
}

void DrawPard2(int i,float x,float h)
{float y1,y2;
     y1=fnc(x,s2_k);
     y2=fnc(x+h,s2_k);
     if ((y1>0)&&(y2>0)){
     glBegin(GL_QUAD_STRIP);
     glVertex3f(x*s2_r*cos(s2_fi*(i+1)),y1*s2_r,x*s2_r*sin((i+1)*s2_fi));
     glVertex3f((x+h)*s2_r*cos(s2_fi*(i+1)),y2*s2_r,(x+h)*s2_r*sin((i+1)*s2_fi));
     glVertex3f(x*s2_r*cos(i*s2_fi),y1*s2_r,x*s2_r*sin(i*s2_fi));
     glVertex3f((x+h)*s2_r*cos(i*s2_fi),y2*s2_r,(x+h)*s2_r*sin(i*s2_fi));
     
     glVertex3f(x*s2_r*cos(s2_fi*i),-y1*s2_r,x*s2_r*sin(i*s2_fi));
     glVertex3f((x+h)*s2_r*cos(s2_fi*i),-y2*s2_r,(x+h)*s2_r*sin(i*s2_fi));
     glVertex3f(x*s2_r*cos(s2_fi*(i+1)),-y1*s2_r,x*s2_r*sin((i+1)*s2_fi));
     glVertex3f((x+h)*s2_r*cos(s2_fi*(i+1)),-y2*s2_r,(x+h)*s2_r*sin((i+1)*s2_fi));
     glEnd();
     
     glBegin(GL_QUAD_STRIP);
     glVertex3f(x*s2_r*cos(i*s2_fi),-y1*s2_r,x*s2_r*sin(i*s2_fi));
     glVertex3f(x*s2_r*cos(i*s2_fi),y1*s2_r,x*s2_r*sin(i*s2_fi));
     glVertex3f(x*s2_r*cos((i+1)*s2_fi),-y1*s2_r,x*s2_r*sin((i+1)*s2_fi));
     glVertex3f(x*s2_r*cos((i+1)*s2_fi),y1*s2_r,x*s2_r*sin((i+1)*s2_fi));
     
     glVertex3f((x+h)*s2_r*cos((i+1)*s2_fi),-y2*s2_r,(x+h)*s2_r*sin((i+1)*s2_fi));
     glVertex3f((x+h)*s2_r*cos((i+1)*s2_fi),y2*s2_r,(x+h)*s2_r*sin((i+1)*s2_fi));
     glVertex3f((x+h)*s2_r*cos(i*s2_fi),-y2*s2_r,(x+h)*s2_r*sin(i*s2_fi));
     glVertex3f((x+h)*s2_r*cos(i*s2_fi),y2*s2_r,(x+h)*s2_r*sin(i*s2_fi));
     glEnd();
     }
}

void display2(void)
{
     glClear(GL_COLOR_BUFFER_BIT|GL_DEPTH_BUFFER_BIT);
     
     glPushMatrix();
     glRotatef(s2_rx,1.0,0.0,0.0);
     glRotatef(s2_ry,0.0,1.0,0.0);
     glRotatef(s2_rz,0.0,0.0,1.0);
     //torocylinder
     glMaterialfv(GL_FRONT,GL_AMBIENT,s2_mat1_amb);
     glMaterialfv(GL_FRONT,GL_DIFFUSE,s2_mat1_dif);
     glMaterialfv(GL_FRONT,GL_SPECULAR,s2_mat1_spec);
     glMaterialf(GL_FRONT,GL_SHININESS,s2_mat1_shininess);
     
     glPushMatrix();
     float x,y;int i;
     
     for (i=0;i<s2_count;i++)
     for (x=0;x<4;x+=0.1)
         DrawPard2(i,x,0.1);
     
     glPopMatrix();
          
     glPopMatrix();
     glFlush();
     glutSwapBuffers();
}

void reshape2(int w,int h)
{
     glViewport(0,0,(GLsizei)w,(GLsizei)h);
     glMatrixMode(GL_PROJECTION);
     glLoadIdentity();
     
     gluPerspective(40.0,(GLfloat)w/h,1,100.0);
     glMatrixMode(GL_MODELVIEW);
     glLoadIdentity();
     gluLookAt(0.0f,0.0f,8.0f,
     0.0f,0.0f,0.0f,
     0.0f,1.0f,0.0f);
}

void redraw2()
{
     s2_t+=0.02;
     s2_k=ka(s2_t);
     glutPostRedisplay();
}

//////////////////////
//  SCENA NUMBER 3  //
//////////////////////

const int s3_cc=5;
int s3_t=0;
const float s3_cs=0.3;
int s3_colls[10][10];

float s3_r,s3_dvx,s3_dvy,s3_dvz;
float s3_x[s3_cc],s3_y[s3_cc],s3_z[s3_cc],s3_vx[s3_cc],s3_vy[s3_cc],s3_vz[s3_cc],
s3_fx[s3_cc],s3_fy[s3_cc],s3_fz[s3_cc],s3_vfx[s3_cc],s3_vfy[s3_cc],s3_vfz[s3_cc];

float s3_vco,s3_wco;
float s3_xc,s3_yc,s3_zc;
float s3_vxp1,s3_vyp1,s3_vzp1,s3_vxp2,s3_vyp2,s3_vzp2;
const float s3_jj=1;

float s3_mat1_diff[]={0.7f,0.0f,0.7f};
float s3_mat1_amb[]={0.7,0.1,0.7};
float s3_mat1_spec[]={0.7f,0.1f,0.7f};
float s3_mat1_shininess=0.7*128;

float s3_mat2_diff[]={0.3f,1.0f,0.3f};
float s3_mat2_amb[]={0.3,0.9,0.3};
float s3_mat2_spec[]={0.3f,0.9f,0.3f};
float s3_mat2_shininess=0.7*128;

float dist2(float x1,float x2,float y1,float y2,float z1,float z2)
{
return (x1-x2)*(x1-x2)+(y1-y2)*(y1-y2)+(z1-z2)*(z1-z2);
}

void init3()
{
     glClearColor(0.0f, 0.0f, 0.0f, 0.0f);
     glClearDepth(1.0);
     glDisable(GL_TEXTURE_2D);
     glEnable(GL_DEPTH_TEST);
     //random
     int i;
     for (i=0;i<s3_cc;i++)
         {
                      s3_x[i]=random(2)-1;
                      s3_y[i]=random(2)-1;
                      s3_z[i]=random(2)-1;
                      s3_vx[i]=random(0.1)-0.05;
                      s3_vy[i]=random(0.1)-0.05;
                      s3_vz[i]=random(0.1)-0.05;
                      
                      s3_fx[i]=random(180);
                      s3_fy[i]=random(180);
                      s3_fz[i]=random(180);
                      s3_vfx[i]=random(2.8)-1.4;
                      s3_vfy[i]=random(2.8)-1.4;
                      s3_vfz[i]=random(2.8)-1.4;
         }
     glMaterialfv(GL_FRONT,GL_AMBIENT,s3_mat1_amb);
     glMaterialfv(GL_FRONT,GL_DIFFUSE,s3_mat1_diff);
     glMaterialfv(GL_FRONT,GL_SPECULAR,s3_mat1_spec);
     glMaterialf(GL_FRONT,GL_SHININESS,s3_mat1_shininess);
     glEnable(GL_LIGHTING);
     glEnable(GL_LIGHT0);         
     
}
//rotate of vector p(px,py,pz) on angles (frx,fry,frz) makes(nx,ny,nz);
int rotp(float px,float py,float pz,float frx,float fry, float frz,float * nx,float * ny,float* nz)
{
    float resx[3],resy[3],resz[3];
resx[0]=cos(fry)*cos(frz);resx[0]=cos(fry)*sin(frz);resz[0]=sin(fry);
resx[1]=sin(frz);resy[1]=cos(frz)*cos(frx);resy[1]=cos(frx)*sin(frz);
resx[2]=sin(fry);resz[2]=cos(frx)*sin(fry);resz[2]=cos(fry)*sin(frx);   

(*nx)=resx[0]*px+resx[1]*py+resx[2]*pz;
(*ny)=resy[0]*px+resy[1]*py+resy[2]*pz;
(*nz)=resz[0]*px+resz[1]*py+resz[2]*pz;
return 0;
}
//collision with boarder, return -1 if not collision of number of vertex if collision
//0,1,2-const x,y,z:min
//3,4,5-const x,y,z:max
int CollBo(int num,int* gran)
{
float arr[8][3];int i,j,k;
float nx,ny,nz;

for (i=0;i<2;i++) for (j=0;j<2;j++) for(k=0;k<2;k++)
{
    rotp(2*i-1,2*j-1,2*k-1,s3_fx[num],s3_fy[num],s3_fz[num],&nx,&ny,&nz);
    arr[i*4+j*2+k][0]=s3_x[num]+nx*s3_cs;
    arr[i*4+j*2+k][1]=s3_y[num]+ny*s3_cs;
    arr[i*4+j*2+k][2]=s3_z[num]+nz*s3_cs;
}

for (i=0;i<8;i++)
{
    if (arr[i][0]<-2) {(*gran)=0;return i;}
    if (arr[i][1]<-2) {(*gran)=1;return i;}
    if (arr[i][2]<-2) {(*gran)=2;return i;}
    if (arr[i][0]>2) {(*gran)=3;return i;}
    if (arr[i][1]>2) {(*gran)=4;return i;}
    if (arr[i][2]>2) {(*gran)=5;return i;}
}
return -1;
}
//collision betweem cubes return -1 if no vertex num2 which is inside num1
int CollBet(int num1,int num2,int *gran)
{
float arr[8][3];int i,j,k;
float nx,ny,nz;

for (i=0;i<2;i++) for (j=0;j<2;j++) for(k=0;k<2;k++)
{
    rotp(2*i-1,2*j-1,2*k-1,s3_fx[num2]-s3_fx[num1],s3_fy[num2]-s3_fy[num1],s3_fz[num2]-s3_fz[num1],&nx,&ny,&nz);
    arr[i*4+j*2+k][0]=(s3_x[num2]-s3_x[num1])+nx*s3_cs;
    arr[i*4+j*2+k][1]=(s3_y[num2]-s3_y[num1])+ny*s3_cs;
    arr[i*4+j*2+k][2]=(s3_z[num2]-s3_z[num1])+nz*s3_cs;
}

for (i=0;i<8;i++)
{
    if( (arr[i][0]>-s3_cs)&&(arr[i][0]<s3_cs)&&(arr[i][1]>-s3_cs)&&(arr[i][1]<s3_cs)&&(arr[i][2]>-s3_cs)&&(arr[i][2]<s3_cs) )
    {
    if ((arr[i][0]>-s3_cs)&&(arr[i][0]<0)) {(*gran)=0;return i;}
    if ((arr[i][1]>-s3_cs)&&(arr[i][1]<0)) {(*gran)=1;return i;}
    if ((arr[i][2]>-s3_cs)&&(arr[i][2]<0)) {(*gran)=2;return i;}
    if ((arr[i][0]<s3_cs)&&(arr[i][0]>0)) {(*gran)=3;return i;}
    if ((arr[i][1]<s3_cs)&&(arr[i][1]>0)) {(*gran)=4;return i;}
    if ((arr[i][2]<s3_cs)&&(arr[i][2]>0)) {(*gran)=5;return i;}
    }
}
return -1;
}
//coordinate of  vertex of collision
int VerCo(int num,int ver)
{
    int kx,ky,kz;
    float nx,ny,nz;
    kx=((ver & 4)==0)*2-1;
    ky=((ver & 2)==0)*2-1;
    kz=((ver & 1)==0)*2-1;
    
    rotp(kx,ky,kz,s3_fx[num],s3_fy[num],s3_fz[num],&nx,&ny,&nz);
    s3_xc=s3_x[num]+kx*s3_cs*cos(s3_fx[num]);
    s3_yc=s3_y[num]+ky*s3_cs*cos(s3_fy[num]);
    s3_zc=s3_z[num]+kz*s3_cs*cos(s3_fz[num]);
    
    s3_xc=s3_x[num]+nx*s3_cs;
    s3_yc=s3_y[num]+ny*s3_cs;
    s3_zc=s3_z[num]+nz*s3_cs;
return 0;
}
//N*dt/m aka pr_N(dv)
float dv(int num1,int num2,int gran,float *dvx,float *dvy,float *dvz)
{
      float nx,ny,nz,res;
      if (gran==0) {nx=-cos(s3_fy[num1])*cos(s3_fz[num1]);ny=-cos(s3_fy[num1])*sin(s3_fz[num1]);nz=-sin(s3_fy[num1]);}
      if (gran==1) {nx=-sin(s3_fz[num1]);ny=-cos(s3_fz[num1])*cos(s3_fx[num1]);nz=-cos(s3_fx[num1])*sin(s3_fz[num1]);}
      if (gran==2) {nx=-sin(s3_fy[num1]);ny=-cos(s3_fx[num1])*sin(s3_fy[num1]);nz=-cos(s3_fy[num1])*sin(s3_fx[num1]);}
      
      if (gran==3) {nx=cos(s3_fy[num1])*cos(s3_fz[num1]);ny=cos(s3_fy[num1])*sin(s3_fz[num1]);nz=sin(s3_fy[num1]);}
      if (gran==4) {nx=sin(s3_fz[num1]);ny=cos(s3_fz[num1])*cos(s3_fx[num1]);nz=cos(s3_fx[num1])*sin(s3_fz[num1]);}
      if (gran==5) {nx=sin(s3_fy[num1]);ny=cos(s3_fx[num1])*sin(s3_fy[num1]);nz=cos(s3_fy[num1])*sin(s3_fx[num1]);}
res=(s3_vxp2-s3_vxp1)*nx+(s3_vyp2-s3_vyp1)*ny+(s3_vzp2-s3_vzp1)*nz;
(*dvx)=nx*res;
(*dvy)=ny*res;
(*dvz)=nz*res;
return res;
}
//dlya razlojeniya
float te(int num)
{
      float res1,res2;
      res1=s3_dvx*(s3_xc-s3_x[num])+s3_dvy*(s3_yc-s3_y[num])+s3_dvz*(s3_zc-s3_z[num]);
      res2=(s3_xc-s3_x[num])*(s3_xc-s3_x[num])+(s3_yc-s3_y[num])*(s3_yc-s3_y[num])+(s3_zc-s3_z[num])*(s3_zc-s3_z[num]);
      return res1/res2;
}
//razlojeniye
int av(int num,float * avx,float *avy,float * avz )
{
    float TE;
    TE=te(num);
    (*avx)=s3_dvx-TE*(s3_xc-s3_x[num]);
    (*avy)=s3_dvy-TE*(s3_yc-s3_y[num]);
    (*avz)=s3_dvz-TE*(s3_zc-s3_z[num]);
      return 0;
}

int palperp(int num1,int num2,float dvx,float dvy,float dvz)
{
    float avx,avy,avz,evx,evy,evz;
//1
av(num1,&avx,&avy,&avz);
evx=dvx-avx;
evy=dvy-avy;
evz=dvz-avz;
//
s3_vx[num1]+=avx;s3_vy[num1]+=avy;s3_vz[num1]+=avz;

s3_vfx[num1]+=(evy*(s3_zc-s3_z[num1])/dist2(s3_x[num1],s3_xc,s3_y[num1],s3_yc,s3_z[num1],s3_zc)- evz*(s3_yc-s3_y[num1])/dist2(s3_x[num1],s3_xc,s3_y[num1],s3_yc,s3_z[num1],s3_zc))*s3_jj;
s3_vfy[num1]+=(evz*(s3_xc-s3_x[num1])/dist2(s3_x[num1],s3_xc,s3_y[num1],s3_yc,s3_z[num1],s3_zc)- evx*(s3_zc-s3_z[num1])/dist2(s3_x[num1],s3_xc,s3_y[num1],s3_yc,s3_z[num1],s3_zc))*s3_jj;
s3_vfz[num1]+=(evx*(s3_yc-s3_y[num1])/dist2(s3_x[num1],s3_xc,s3_y[num1],s3_yc,s3_z[num1],s3_zc)- evy*(s3_xc-s3_x[num1])/dist2(s3_x[num1],s3_xc,s3_y[num1],s3_yc,s3_z[num1],s3_zc))*s3_jj;

//2
av(num2,&avx,&avy,&avz);
evx=dvx-avx;
evy=dvy-avy;
evz=dvz-avz;
//
s3_vx[num2]-=avx;s3_vy[num2]-=avy;s3_vz[num2]-=avz;

s3_vfx[num1]-=(evy*(s3_zc-s3_z[num2])/dist2(s3_x[num2],s3_xc,s3_y[num2],s3_yc,s3_z[num2],s3_zc)- evz*(s3_yc-s3_y[num2])/dist2(s3_x[num2],s3_xc,s3_y[num2],s3_yc,s3_z[num2],s3_zc))*s3_jj;
s3_vfy[num1]-=(evz*(s3_xc-s3_x[num2])/dist2(s3_x[num2],s3_xc,s3_y[num2],s3_yc,s3_z[num2],s3_zc)- evx*(s3_zc-s3_z[num2])/dist2(s3_x[num2],s3_xc,s3_y[num2],s3_yc,s3_z[num2],s3_zc))*s3_jj;
s3_vfz[num1]-=(evx*(s3_yc-s3_y[num2])/dist2(s3_x[num2],s3_xc,s3_y[num2],s3_yc,s3_z[num2],s3_zc)- evy*(s3_xc-s3_x[num2])/dist2(s3_x[num2],s3_xc,s3_y[num2],s3_yc,s3_z[num2],s3_zc))*s3_jj;
}
//Collision
void Collision(int num1,int num2,int gran,int ver)
{
float nx,ny,nz;     const float ccc=6;
float s3_kb,s3_ke;
s3_kb=sqrt(s3_vx[num1]*s3_vx[num1] + s3_vy[num1]*s3_vy[num1] + s3_vz[num1]*s3_vz[num1]+
s3_vx[num2]*s3_vx[num2] + s3_vy[num2]*s3_vy[num2] + s3_vz[num2]*s3_vz[num2]);

s3_ke=sqrt(s3_vx[num1]*s3_vx[num1] + s3_vy[num1]*s3_vy[num1] + s3_vz[num1]*s3_vz[num1]+
s3_vx[num2]*s3_vx[num2] + s3_vy[num2]*s3_vy[num2] + s3_vz[num2]*s3_vz[num2]);

VerCo(num2,ver);
s3_vxp1=s3_vx[num1]+(s3_vfy[num1]*(s3_zc-s3_z[num1])- s3_vfz[num1]*(s3_yc-s3_y[num1]))*M_PI/180/ccc;
s3_vyp1=s3_vy[num1]+(s3_vfz[num1]*(s3_xc-s3_x[num1])- s3_vfx[num1]*(s3_zc-s3_z[num1]))*M_PI/180/ccc;
s3_vzp1=s3_vz[num1]+(s3_vfx[num1]*(s3_yc-s3_y[num1])- s3_vfy[num1]*(s3_xc-s3_x[num1]))*M_PI/180/ccc;

s3_vxp2=s3_vx[num2]+(s3_vfy[num2]*(s3_zc-s3_z[num2])- s3_vfz[num2]*(s3_yc-s3_y[num2]))*M_PI/180/ccc;
s3_vyp2=s3_vy[num2]+(s3_vfz[num2]*(s3_xc-s3_x[num2])- s3_vfx[num2]*(s3_zc-s3_z[num2]))*M_PI/180/ccc;
s3_vzp2=s3_vz[num2]+(s3_vfx[num2]*(s3_yc-s3_y[num2])- s3_vfy[num2]*(s3_xc-s3_x[num2]))*M_PI/180/ccc;

s3_vco=dv(num1,num2,gran,&s3_dvx,&s3_dvy,&s3_dvz);
palperp(num1,num2,s3_dvx,s3_dvy,s3_dvz);

s3_vx[num1]=s3_vx[num1]*s3_kb/s3_ke;
s3_vy[num1]=s3_vy[num1]*s3_kb/s3_ke;
s3_vz[num1]=s3_vz[num1]*s3_kb/s3_ke;

s3_vx[num2]=s3_vx[num2]*s3_kb/s3_ke;
s3_vy[num2]=s3_vy[num2]*s3_kb/s3_ke;
s3_vz[num2]=s3_vz[num2]*s3_kb/s3_ke;

if (s3_vx[num1]>0.1) s3_vx[num1]=0.1; 
if (s3_vx[num2]>0.1) s3_vx[num2]=0.1; 
if (s3_vy[num1]>0.1) s3_vy[num1]=0.1; 
if (s3_vy[num2]>0.1) s3_vy[num2]=0.1; 
if (s3_vy[num1]>0.1) s3_vz[num1]=0.1; 
if (s3_vy[num2]>0.1) s3_vz[num2]=0.1; 

if (s3_vx[num1]<-0.1) s3_vx[num1]=-0.1; 
if (s3_vx[num2]<-0.1) s3_vx[num2]=-0.1; 
if (s3_vy[num1]<-0.1) s3_vy[num1]=-0.1; 
if (s3_vy[num2]<-0.1) s3_vy[num2]=-0.1; 
if (s3_vy[num1]<-0.1) s3_vz[num1]=-0.1; 
if (s3_vy[num2]<-0.1) s3_vz[num2]=-0.1; 
}
//Boadrers
void DrawRoom3()
{
     float drx=-2.0,drX=2.0,dry=-2.0,drY=2.0,drz=-2.0,drZ=2.0;
     glutWireCube(4.0);
}
     
void DrawI3(int i)
{
     glPushMatrix();
     glTranslatef(s3_x[i],s3_y[i],s3_z[i]);
     glRotatef(s3_fx[i],1.0,0.0,0.0);
     glRotatef(s3_fy[i],0.0,1.0,0.0);
     glRotatef(s3_fz[i],0.0,0.0,1.0);
     
     float x_1=-s3_cs,x_2=s3_cs,y_1=-s3_cs,y_2=s3_cs,z_1=-s3_cs,z_2=s3_cs;
     glutSolidCube(2*s3_cs);
     glPopMatrix();
}

void display3(void)
{    
     int i=0,j=0;
     glClear(GL_COLOR_BUFFER_BIT|GL_DEPTH_BUFFER_BIT|GL_STENCIL_BUFFER_BIT);
     glPushMatrix();
         
     glMaterialfv(GL_FRONT,GL_AMBIENT,s3_mat1_amb);
     glMaterialfv(GL_FRONT,GL_DIFFUSE,s3_mat1_diff);
     glMaterialfv(GL_FRONT,GL_SPECULAR,s3_mat1_spec);
     glMaterialf(GL_FRONT,GL_SHININESS,s3_mat1_shininess);
     
     DrawRoom3();
     
     glMaterialfv(GL_FRONT,GL_AMBIENT,s3_mat2_amb);
     glMaterialfv(GL_FRONT,GL_DIFFUSE,s3_mat2_diff);
     glMaterialfv(GL_FRONT,GL_SPECULAR,s3_mat2_spec);
     glMaterialf(GL_FRONT,GL_SHININESS,s3_mat2_shininess);
     
     for(i=0;i<s3_cc;i++)
     {
                      int gran[1],cb=CollBo(i,gran);
                      if (cb!=-1)
                      {
                      if ((*gran)==0) {s3_vx[i]=fabs(s3_vx[i]);s3_vfx[i]=-s3_vfx[i];}
                      if ((*gran)==1) {s3_vy[i]=fabs(s3_vy[i]);s3_vfy[i]=-s3_vfy[i];}
                      if ((*gran)==2) {s3_vz[i]=fabs(s3_vz[i]);s3_vfz[i]=-s3_vfz[i];}
                      
                      if ((*gran)==3) {s3_vx[i]=-fabs(s3_vx[i]);s3_vfx[i]=-s3_vfx[i];}
                      if ((*gran)==4) {s3_vy[i]=-fabs(s3_vy[i]);s3_vfy[i]=-s3_vfy[i];}
                      if ((*gran)==5) {s3_vz[i]=-fabs(s3_vz[i]);s3_vfz[i]=-s3_vfz[i];}
                      }
                     
                     s3_x[i]+=s3_vx[i];s3_y[i]+=s3_vy[i];s3_z[i]+=s3_vz[i];
                     s3_fx[i]+=s3_vfx[i];s3_fy[i]+=s3_vfy[i];s3_fz[i]+=s3_vfz[i];
                     
                     DrawI3(i);
                     s3_dvx=0;s3_dvy=0;s3_dvz=0;
     }
     
     for (i=0;i<s3_cc;i++) for (j=0;j<s3_cc;j++) if ( (i!=j)&&(s3_colls[i][j]==0))
     {
         int gran[1],cb=CollBet(i,j,gran);
         if (cb!=-1)
         {
         Collision(i,j,gran[0],cb);
         s3_colls[i][j]=2;           
         }
     }
     
     for (i=0;i<s3_cc;i++) for (j=0;j<s3_cc;j++) if (s3_colls[i][j]>0) s3_colls[i][j]--;
     glEnd();
     glPopMatrix();
     
     glPopMatrix();
     glFlush();
     glutSwapBuffers();
}

void reshape3(int w,int h)
{
     glViewport(0,0,(GLsizei)w,(GLsizei)h);
     glMatrixMode(GL_PROJECTION);
     glLoadIdentity();
     
     gluPerspective(40.0,(GLfloat)w/h,1,100.0);
     glMatrixMode(GL_MODELVIEW);
     
     glLoadIdentity();
     gluLookAt(0.0f,0.0f,8.0f,
     0.0f,0.0f,0.0f,
     0.0f,1.0f,0.0f);
}

void redraw3()
{
int p;
for (p=0;p<9000000;p++) p=p;
     glutPostRedisplay();
}
//////////////////////
//  SCENA NUMBER 0  //
//////////////////////
float ry=0.0f,mx=0.0f,my=0.0f,mz=0.0f;
float ro=0.7,roo=0.4;
float rmeln=0;
float mas0[6],mas15[6],mas30[6],masdep[6];
float rch=1.7,hch=0.3,rsr;

const float scs=9.0f;
float x_1=-scs,x_2=scs,y_2=-2.0f,z_1=-scs,z_2=scs;
GLfloat xrot,yrot,zrot;
int count=8;int i=0,j=0;
GLUquadricObj* QuadrObj;

float mat1_diff[]={0.8f,0.0f,0.8f};
float mat1_amb[]={0.2,0.2,0.2};
float mat1_spec[]={0.6f,0.6f,0.6f};
float mat1_shininess=0.5*128;

float mat2_diff[]={0.8f,0.5f,0.1f};
float mat2_amb[]={0.8,0.5,0.2};
float mat2_spec[]={0.5f,0.3f,0.1f};
float mat2_shininess=0.7*128;

GLuint	texture[5];

const float ddt=0.25;
AUX_RGBImageRec* proctex;

GLfloat data[6][6][3]={
{{-5*ddt,0.0,-5*ddt},{-3*ddt,0.0,-5*ddt},{-ddt,0.0,-5*ddt},{ddt,0.0,-5*ddt},{3*ddt,0.0,-5*ddt},{5*ddt,0.0,-5*ddt}},
{{-5*ddt,0.0,-3*ddt},{-3*ddt,0.2,-3*ddt},{-ddt,1.0,-3*ddt},{ddt,0.4,-3*ddt},{3*ddt,0.2,-3*ddt},{5*ddt,0.0,-3*ddt}},
{{-5*ddt,0.0,-ddt},  {-3*ddt,0.5,-ddt},  {-ddt,2.5,-ddt},  {ddt,2.0,-ddt},  {3*ddt,0.5,-ddt},  {5*ddt,0.0,-ddt}},
{{-5*ddt,0.0,ddt},   {-3*ddt,0.4,ddt},   {-ddt,2.0,ddt},   {ddt,1.6,ddt},   {3*ddt,0.4,ddt},   {5*ddt,0.0,ddt}},
{{-5*ddt,0.0,3*ddt}, {-3*ddt,0.2,3*ddt}, {-ddt,1.0,3*ddt}, {ddt,0.8,3*ddt}, {3*ddt,0.2,3*ddt}, {5*ddt,0.0,3*ddt}},
{{-5*ddt,0.0,5*ddt}, {-3*ddt,0.0,5*ddt}, {-ddt,0.0,5*ddt}, {ddt,0.0,5*ddt}, {3*ddt,0.0,5*ddt}, {5*ddt,0.0,5*ddt}}
};

struct field
{
  float U[128][128];
};
field A,B;
field *p=&A,*n=&B;
// Создание проц. текстуры
void MakeTex(void)
{
     int i,j,i1,j1;
     srand(RAND_MAX);
  i1=rand()%127;
  j1=rand()%127;
  if((rand()&127)==0)
  for(i=-3;i<4;i++)
  {
    for(j=-3;j<4;j++)
    {
      float v=6.0f-i*i-j*j;
      if(v<0.0f)v=0.0f;
      n->U[i+i1+3][j+j1+3]-=v*0.004f;
    }
  }
const float vis=0.001,sc=20;
proctex=(AUX_RGBImageRec*)malloc(sizeof(int)*2+4);
proctex->data=(unsigned char *)malloc(128*128*3);
proctex->sizeX=128;
proctex->sizeY=128;
 for (i=0;i<128;i++) for (j=0;j<128;j++)
 {
           float laplas=(n->U[i-1][j]+
                n->U[i+1][j]+
                n->U[i][j+1]+
                n->U[i][j-1])*0.25f-n->U[i][j];
      p->U[i][j]=(1.0-vis)*(n->U[i][j])-(p->U[i][j])*(1.0f-vis)+laplas;
     
 }   
 for (i=0;i<128;i++) for (j=0;j<128;j++)
 {
 proctex->data[i*128*3+j*3+0]=(unsigned char)(255*(0.3+0.4*sc*n->U[i][j]));
 proctex->data[i*128*3+j*3+1]=(unsigned char)(255*(0.5+sc*n->U[i][j]));
 proctex->data[i*128*3+j*3+2]=(unsigned char)(255*(0.1+0*sc*n->U[i][j]));
 }
field *sw=p;p=n;n=sw;
}

GLvoid initTex()
{
       int i,j;
    // Загрузка картинок
	AUX_RGBImageRec *texture1; 
	AUX_RGBImageRec * texture2;
	AUX_RGBImageRec * texture3;
	AUX_RGBImageRec * texture4;
	texture1 = auxDIBImageLoadA("Data/003.bmp");
	texture2 = auxDIBImageLoadA("Data/8.bmp");
	texture3 = auxDIBImageLoadA("Data/1.bmp");
	texture4 = auxDIBImageLoadA("Data/sky.bmp");
		
	glGenTextures(4, &texture[0]);
	glBindTexture(GL_TEXTURE_2D, texture[0]);
	glTexParameteri(GL_TEXTURE_2D,GL_TEXTURE_MAG_FILTER,GL_LINEAR);
	glTexParameteri(GL_TEXTURE_2D,GL_TEXTURE_MIN_FILTER,GL_LINEAR);
	glTexImage2D(GL_TEXTURE_2D, 0, 3, texture1->sizeX, texture1->sizeY, 0, GL_RGB, GL_UNSIGNED_BYTE, texture1->data);
	
    glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);
    glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);
	
	glBindTexture(GL_TEXTURE_2D, texture[1]);
	
	unsigned char dat[64][64][4];
	
	for (i=0;i<64;i++) for (j=0;j<64;j++)
	{
        dat[i][j][0]=texture2->data[i*64*3+j*3+0];
        dat[i][j][1]=texture2->data[i*64*3+j*3+1];
        dat[i][j][2]=texture2->data[i*64*3+j*3+2];
        if ((dat[i][j][2]==0)&&(dat[i][j][1]==0)&&(dat[i][j][0]==0)) dat[i][j][3]=0;
        else dat[i][j][3]=255;
    }
    texture2->data=(unsigned char*)malloc(64*64*4);
    
    for (i=0;i<64;i++) for (j=0;j<64;j++)
	{
        texture2->data[i*64*4+j*4+0]=dat[i][j][0];
        texture2->data[i*64*4+j*4+1]=dat[i][j][1];
        texture2->data[i*64*4+j*4+2]=dat[i][j][2];
        texture2->data[i*64*4+j*4+3]=dat[i][j][3];
    }

	glTexParameteri(GL_TEXTURE_2D,GL_TEXTURE_MAG_FILTER,GL_LINEAR);
	glTexParameteri(GL_TEXTURE_2D,GL_TEXTURE_MIN_FILTER,GL_LINEAR);
	glTexImage2D(GL_TEXTURE_2D, 0, 4, texture2->sizeX, texture2->sizeY, 0, GL_RGBA, GL_UNSIGNED_BYTE, texture2->data);
	
    glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);
    glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);
    
	glBindTexture(GL_TEXTURE_2D, texture[2]);
for (int ggg=0;ggg<1000;ggg++);	MakeTex();
	glTexParameteri(GL_TEXTURE_2D,GL_TEXTURE_MAG_FILTER,GL_LINEAR);
	glTexParameteri(GL_TEXTURE_2D,GL_TEXTURE_MIN_FILTER,GL_LINEAR);
	glTexImage2D(GL_TEXTURE_2D, 0, 3, 128, 128, 0, GL_RGB, GL_UNSIGNED_BYTE, proctex->data);
	
    glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);
    glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);
    
	glBindTexture(GL_TEXTURE_2D, texture[3]);
	glTexParameteri(GL_TEXTURE_2D,GL_TEXTURE_MAG_FILTER,GL_LINEAR);
	glTexParameteri(GL_TEXTURE_2D,GL_TEXTURE_MIN_FILTER,GL_LINEAR);
	glTexImage2D(GL_TEXTURE_2D, 0, 3, texture3->sizeX, texture3->sizeY, 0, GL_RGB, GL_UNSIGNED_BYTE, texture3->data);
	
    glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);
    glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);

	glBindTexture(GL_TEXTURE_2D, texture[4]);
	glTexParameteri(GL_TEXTURE_2D,GL_TEXTURE_MAG_FILTER,GL_LINEAR);
	glTexParameteri(GL_TEXTURE_2D,GL_TEXTURE_MIN_FILTER,GL_LINEAR);
	glTexImage2D(GL_TEXTURE_2D, 0, 3, texture4->sizeX, texture4->sizeY, 0, GL_RGB, GL_UNSIGNED_BYTE, texture4->data);
	
    glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);
    glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);
}

void init()
{
     initTex();
     //for spline
     glMap2f(GL_MAP2_VERTEX_3,-5*ddt,5*ddt,3,6,-5*ddt,5*ddt,18,6,&data[0][0][0]);
     glEnable(GL_MAP2_VERTEX_3);
     glEnable(GL_AUTO_NORMAL);
     glMapGrid2f(20,-5*ddt,5*ddt,20,0.0,1.0);
     glEnable(GL_DEPTH_TEST);     
          
     for (i=0;i<6;i++)
     {
         mas0[i]=random(1);
         mas30[i]=random(1);
         mas15[i]=random((mas0[i]+mas30[i])/2);
         masdep[i]=random(0.9);
     }                     
     
    glClearColor(0.0f, 0.0f, 0.0f, 0.0f);
    glClearDepth(1.0);
	glDepthFunc(GL_LESS);	
	glEnable(GL_DEPTH_TEST);
	glShadeModel(GL_SMOOTH);
	glMatrixMode(GL_PROJECTION);
	glLoadIdentity();		
	gluPerspective(60.0f,(GLfloat)700/(GLfloat)700,0.1f,60.0f);
							
	glMatrixMode(GL_MODELVIEW);
     glEnable(GL_LIGHTING);
     glEnable(GL_LIGHT0);
}

void DrawMeln(void)
{
     glPushMatrix();
     
     glEnable(GL_DEPTH_TEST);
     glClearDepth(1.0);
     glDisable(GL_TEXTURE);
     
     glMaterialfv(GL_FRONT,GL_AMBIENT,mat2_amb);
     glMaterialfv(GL_FRONT,GL_DIFFUSE,mat2_diff);
     glMaterialfv(GL_FRONT,GL_SPECULAR,mat2_spec);
     glMaterialf(GL_FRONT,GL_SHININESS,mat2_shininess);
     
     glTranslatef(2.0,0.0,0.0);
     glRotatef(rmeln,0.0,0.0,1.0);
     
     //lopasti
     for (i=0;i<4;i++)
     {
         glBegin(GL_QUAD_STRIP);
         glVertex3f(0,0,0);
         glVertex3f(0,0,hch);         
         glVertex3f(rch*cos((90*i)*M_PI/180),rch*sin((90*i)*M_PI/180),0);
         glVertex3f(rch*cos((90*i)*M_PI/180),rch*sin((90*i)*M_PI/180),hch);
         glVertex3f(rch*cos((90*i+15)*M_PI/180),rch*sin((90*i+15)*M_PI/180),0);
         glVertex3f(rch*cos((90*i+15)*M_PI/180),rch*sin((90*i+15)*M_PI/180),hch); 
         glVertex3f(0,0,0);
         glVertex3f(0,0,hch);   
         glEnd();     
         
         glBegin(GL_TRIANGLES);
         glVertex3f(0,0,0);
         glVertex3f(rch*cos((90*i)*M_PI/180),rch*sin((90*i)*M_PI/180),0);
         glVertex3f(rch*cos((90*i+15)*M_PI/180),rch*sin((90*i+15)*M_PI/180),0);         
         
         glVertex3f(0,0,hch);
         glVertex3f(rch*cos((90*i)*M_PI/180),rch*sin((90*i)*M_PI/180),hch);
         glVertex3f(rch*cos((90*i+15)*M_PI/180),rch*sin((90*i+15)*M_PI/180),hch);
         glEnd();
     }
     glRotatef(-rmeln,0,0,1);
     
     glTranslatef(0.0,-1.5,-0.4);
     glRotatef(90.0,0,1,0);
     glRotatef(-90.0,1,0,0);
     QuadrObj=gluNewQuadric();
     gluCylinder(QuadrObj,ro,roo,2.5,15,15);
     
     glTranslatef(0.0,0.0,3.0);
     glutSolidCone(roo,0.5,15,15);
     glTranslatef(0.0,0.0,-3.0);

     glTranslatef(0.0,0.0,-0.5);
     glRotatef(90,0,0,1);
     
     glBegin(GL_QUAD_STRIP);
     for (i=3;i<9;i++)
     {
         glVertex3f(ro*cos((30*i)*M_PI/180),ro*sin((30*i)*M_PI/180),0);
         glVertex3f(ro*cos((30*i)*M_PI/180),ro*sin((30*i)*M_PI/180),0.5);     
     }
     glVertex3f(ro*cos((30*3)*M_PI/180),ro*sin((30*3)*M_PI/180),0);
     glVertex3f(ro*cos((30*3)*M_PI/180),ro*sin((30*3)*M_PI/180),0.5);     
     glEnd();
     
     glBegin(GL_QUAD_STRIP);
     for (i=9;i<15;i++)
     {
         glVertex3f(ro*cos((30*i)*M_PI/180),ro*sin((30*i)*M_PI/180),0);
         glVertex3f(ro*cos((30*i)*M_PI/180),ro*sin((30*i)*M_PI/180),0.5);     
     }
     glVertex3f(ro*cos((30*9)*M_PI/180),ro*sin((30*9)*M_PI/180),0);
     glVertex3f(ro*cos((30*9)*M_PI/180),ro*sin((30*9)*M_PI/180),0.5);     
     glEnd();   
     
     glBegin(GL_POLYGON);
     for  (i=3;i<9;i++) glVertex3f(ro*cos((30*i)*M_PI/180),ro*sin((30*i)*M_PI/180),0);
     glEnd();
     
     glBegin(GL_POLYGON);
     for  (i=9;i<15;i++) glVertex3f(ro*cos((30*i)*M_PI/180),ro*sin((30*i)*M_PI/180),0);
     glEnd();
     
     glBegin(GL_POLYGON);
     for  (i=3;i<9;i++) glVertex3f(ro*cos((30*i)*M_PI/180),ro*sin((30*i)*M_PI/180),0.5);
     glEnd();
     
     glBegin(GL_POLYGON);
     for  (i=9;i<15;i++) glVertex3f(ro*cos((30*i)*M_PI/180),ro*sin((30*i)*M_PI/180),0.5);
     glEnd();
     //verh
     glTranslatef(0,0,3.0);
     
     int l=0;
     for (l=0;l<4;l++) {glRotatef(90,0,0,1);
     glBegin(GL_QUAD_STRIP);
     glVertex3f(roo*3/10,roo*3/10,0);
     glVertex3f(roo*3/10,roo*3/10,0.5);
     for (i=3;i<10;i++) {glVertex3f(roo*i/10,roo*sqrt(1-0.01*i*i),0);
     glVertex3f(roo*i/10,roo*sqrt(1-0.01*i*i),0.5);}
     
     glVertex3f(roo,0.3*roo,0); 
     glVertex3f(roo,0.3*roo,0.5);    
     glVertex3f(roo*3/10,roo*3/10,0);
     glVertex3f(roo*3/10,roo*3/10,0.5);
     glEnd();

     glBegin(GL_POLYGON);
     glVertex3f(roo*3/10,roo*3/10,0.5);
     for (i=3;i<10;i++) glVertex3f(roo*i/10,roo*sqrt(1-0.01*i*i),0.5);
     glVertex3f(roo,0.3*roo,0.5); 
     glEnd();
     
     glBegin(GL_POLYGON);
     glVertex3f(roo*3/10,roo*3/10,0);
     for (i=3;i<10;i++) glVertex3f(roo*i/10,roo*sqrt(1-(i*i*0.01)),0.0);
     glVertex3f(roo,0.3*roo,0);
     glEnd();}
     
     glPopMatrix();
}

void DrawSo(void)
{
     glPushMatrix();
     
     glMaterialfv(GL_FRONT,GL_AMBIENT,mat1_amb);
     glMaterialfv(GL_FRONT,GL_DIFFUSE,mat1_diff);
     glMaterialfv(GL_FRONT,GL_SPECULAR,mat1_spec);
     glMaterialf(GL_FRONT,GL_SHININESS,mat1_shininess);

     glTranslatef(-3.5,-2.0,-1.0);
     glEnable(GL_MAP2_VERTEX_3);
     glEnable(GL_AUTO_NORMAL);     
     glEvalMesh2(GL_FILL,0,20,0,20);
     
     glPopMatrix();      
}

const float bbw=0.05,bbh=0.7,delta=0.3;
float bbx[25],bbz[25];

void DrawBB(void)
{
     int i,j;
     glPushMatrix();
     
     for (i=0;i<5;i++) for (j=0;j<5;j++)
     {
         int _k_=2+abs(i-2);
       bbz[5*i+j]=(i-2)*delta;
       bbx[5*i+j]=(j-2)*_k_*delta/4;               
     }
     glEnable(GL_TEXTURE_2D);
     glEnable(GL_ALPHA_TEST);
     glEnable(GL_BLEND);
     glBlendFunc(GL_DST_ALPHA,GL_ONE);
     glDisable(GL_DEPTH_TEST);
     glDisable(GL_LIGHTING);
     glColor4f(0.0f,0.0f,0.0f,0.0f);
     glBindTexture(GL_TEXTURE_2D, texture[1]);
     glTexEnvf( GL_TEXTURE_ENV, GL_TEXTURE_ENV_MODE, GL_DECAL ); 	
     
     int bb_a[25];float bb_b[25];
     for (i=0;i<25;i++)
     {
         bb_b[i]=bbx[i]*sin(ry*M_PI/180)+bbz[i]*cos(M_PI*ry/180);
         bb_a[i]=i;
     }
     
     for (i=0;i<25;i++)
         for (j=0;j<i;j++)
         if (bb_b[j]>bb_b[i])
            {
            int c;
            c=bb_a[i];
            bb_a[i]=bb_a[j];
            bb_a[j]=c;
            }
     
     for (i=0;i<25;i++)
     {
         glPushMatrix();
         glEnable(GL_DEPTH_TEST);
         glTranslatef(bbx[bb_a[i]],-2,bbz[bb_a[i]]);        
         glRotatef(ry,0,-1,0);
         glBegin(GL_QUADS);
         glTexCoord2f(0.0f,0.0f);glVertex3f(-bbw,0,  0);
         glTexCoord2f(0.0f,1.0f);glVertex3f(-bbw,bbh,0);
         glTexCoord2f(1.0f,1.0f);glVertex3f(bbw, bbh,0);
         glTexCoord2f(1.0f,0.0f);glVertex3f(bbw, 0,  0);
         glEnd();
         glPopMatrix();
     }
     
     glTexEnvf(GL_TEXTURE_ENV,GL_TEXTURE_ENV_MODE,(float)GL_REPLACE);
     glDisable(GL_TEXTURE);
     glDisable(GL_BLEND);
     glEnable(GL_LIGHTING);
     glEnable(GL_DEPTH_TEST);
     glDisable(GL_ALPHA_TEST);
     glPopMatrix();
}

void DrawStone(void)
{
     glBindTexture(GL_TEXTURE_2D,texture[3]);
     glBegin(GL_QUADS);
     glTexCoord2f(0.0,0.0);glVertex3f(-scs,-2.0,scs);
     glTexCoord2f(0.0,1.0);glVertex3f(-scs,5.0,scs);
     glTexCoord2f(1.0,1.0);glVertex3f(scs,5.0,scs);
     glTexCoord2f(1.0,0.0);glVertex3f(scs,-2.0,scs);  
        
     glTexCoord2f(0.0,0.0);glVertex3f(scs,-2.0,-scs);
     glTexCoord2f(0.0,1.0);glVertex3f(scs,5.0,-scs);
     glTexCoord2f(1.0,1.0);glVertex3f(scs,5.0,scs);
     glTexCoord2f(1.0,0.0);glVertex3f(scs,-2.0,scs); 

     glTexCoord2f(0.0,0.0);glVertex3f(-scs,-2.0,-scs);
     glTexCoord2f(0.0,1.0);glVertex3f(-scs,5.0,-scs);
     glTexCoord2f(1.0,1.0);glVertex3f(scs,5.0,-scs);
     glTexCoord2f(1.0,0.0);glVertex3f(scs,-2.0,-scs); 
     
     glTexCoord2f(0.0,0.0);glVertex3f(-scs,-2.0,-scs);
     glTexCoord2f(0.0,1.0);glVertex3f(-scs,5.0,-scs);
     glTexCoord2f(1.0,1.0);glVertex3f(-scs,5.0,scs);
     glTexCoord2f(1.0,0.0);glVertex3f(-scs,-2.0,scs);      
     glEnd();     
}

void DrawLuja(void)
{
     glEnable(GL_TEXTURE);
     MakeTex();
	 glEnable(GL_FOG);
     glBindTexture(GL_TEXTURE_2D,texture[2]);
     glTexImage2D(GL_TEXTURE_2D, 0, 3, 128, 128, 0, GL_RGB, GL_UNSIGNED_BYTE, proctex->data);
     glBegin(GL_QUADS);
     glTexCoord2f(0.0,0.0);glVertex3f(-1.0,-2.0,1);
     glTexCoord2f(0.0,1.0);glVertex3f(-1.0,-2.0,3);
     glTexCoord2f(1.0,1.0);glVertex3f(1.0,-2.0,3);
     glTexCoord2f(1.0,0.0);glVertex3f(1.0,-2.0,1);
     glEnd();
     glDisable(GL_TEXTURE);
     glDisable(GL_FOG);
}

void DrawSky(void)
{
     glBindTexture(GL_TEXTURE_2D,texture[4]);
     glBegin(GL_QUADS);
     glTexCoord2f(0.0,0.0);glVertex3f(-scs,5.0,-scs);
     glTexCoord2f(0.0,1.0);glVertex3f(-scs,5.0,scs);
     glTexCoord2f(1.0,1.0);glVertex3f(scs,5.0,scs);     
     glTexCoord2f(1.0,0.0);glVertex3f(scs,5.0,-scs);
     glEnd();
     glDisable(GL_TEXTURE);
}

void DrawGeom(void)
{
     GLfloat FC[4]={0.5,0.5,0.5,1};
     glEnable(GL_FOG);
     glFogi(GL_FOG_MODE,GL_EXP);
     glFogf(GL_FOG_START,4.0);
     glFogf(GL_FOG_END,17.0);
     glFogf(GL_FOG_DENSITY,0.2);
     glFogfv(GL_FOG_COLOR,FC);
     glPushMatrix();
     
     glMaterialfv(GL_FRONT,GL_AMBIENT,mat1_amb);
     glMaterialfv(GL_FRONT,GL_DIFFUSE,mat1_diff);
     glMaterialfv(GL_FRONT,GL_SPECULAR,mat1_spec);
     glMaterialf(GL_FRONT,GL_SHININESS,mat1_shininess);

     glEnable(GL_TEXTURE_2D);
     glBindTexture(GL_TEXTURE_2D, texture[0]); 
     glBegin(GL_QUADS);
     glTexCoord2f(0.0f,0.0f); glVertex3f(x_1,y_2,z_1);
     glTexCoord2f(0.0f,1.0f);  glVertex3f(x_1,y_2,z_2);
     glTexCoord2f(1.0f,1.0f); glVertex3f(x_2,y_2,z_2);
     glTexCoord2f(1.0f,0.0f); glVertex3f(x_2,y_2,z_1);     
     glEnd();
     glDisable(GL_TEXTURE_2D);
     glPopMatrix();

     glDisable(GL_FOG);
    
     glEnable(GL_STENCIL_TEST);          
     glClear(GL_STENCIL_BUFFER_BIT);
     glStencilFunc(GL_ALWAYS,0x1,0x1);
     glStencilOp(GL_INCR,GL_INCR,GL_INCR);
	 glColorMask(FALSE,FALSE,FALSE,FALSE);
	 glDepthMask(FALSE);
     glPushMatrix();
     
     const float niz=-2,verh=0.01;
     glBegin(GL_QUADS);
     glVertex3f(-scs,niz,-scs);glVertex3f(-scs,niz,scs);glVertex3f(scs,niz,scs);glVertex3f(scs,niz,-scs);
     glVertex3f(-scs,verh,-scs);glVertex3f(-scs,verh,scs);glVertex3f(scs,verh,scs);glVertex3f(scs,verh,-scs);
     
     glVertex3f(-scs,niz,-scs);glVertex3f(-scs,niz,scs);glVertex3f(-scs,verh,scs);glVertex3f(-scs,verh,-scs);
     glVertex3f(scs,niz,-scs);glVertex3f(scs,niz,scs);glVertex3f(scs,verh,scs);glVertex3f(scs,verh,-scs);
     
     glVertex3f(-scs,niz,-scs);glVertex3f(-scs,verh,-scs);glVertex3f(scs,verh,-scs);glVertex3f(scs,niz,-scs);
     glVertex3f(-scs,niz,scs);glVertex3f(-scs,verh,scs);glVertex3f(scs,verh,scs);glVertex3f(scs,niz,scs);
     glEnd();
     glPopMatrix();
      
     glColorMask(TRUE,TRUE,TRUE,TRUE);
	 glDepthMask(TRUE);
 	 glStencilFunc(GL_NOTEQUAL, 0x1, 0x1);
	 glStencilOp(GL_KEEP, GL_KEEP, GL_KEEP);
     DrawMeln();
     
     glStencilFunc(GL_EQUAL, 0x1, 0x1);
     glEnable(GL_FOG);
     DrawMeln();
     
     glDisable(GL_STENCIL_TEST);
     glEnable(GL_FOG);
     DrawSo();
     glDisable(GL_FOG);
     DrawBB(); 
     DrawLuja();

     glEnable(GL_STENCIL_TEST);
 	 glStencilFunc(GL_NOTEQUAL, 0x1, 0x1);
	 glStencilOp(GL_KEEP, GL_KEEP, GL_KEEP);
     DrawStone();
     
     glStencilFunc(GL_EQUAL, 0x1, 0x1);
     glEnable(GL_FOG);
     DrawStone();
     glDisable(GL_STENCIL_TEST);
     
     glDisable(GL_FOG);
     DrawSky();

     glColorMask(TRUE,TRUE,TRUE,TRUE);
	 glDepthMask(TRUE);

}     

void display(void)
{
     glClear(GL_COLOR_BUFFER_BIT|GL_DEPTH_BUFFER_BIT|GL_STENCIL_BUFFER_BIT);
     glDisable(GL_FOG);
     
     glPushMatrix();
     
     glTranslatef(mx,my,mz);
     glRotatef(ry,0.0,1.0,0.0);
     glEnable(GL_LIGHTING);
     DrawGeom();
          
     glDisable(GL_DEPTH_TEST);

     glDisable(GL_STENCIL_TEST);
     glPopMatrix();
     
     glFlush();
     glutSwapBuffers();
     glEnable(GL_LIGHTING);
     glClearColor(0.0,0.0,0.0,0.0);
}

void reshape(int w,int h)
{
     glViewport(0,0,(GLsizei)w,(GLsizei)h);
     glMatrixMode(GL_PROJECTION);
     glLoadIdentity();
     gluPerspective(60.0,(GLfloat)w/h,0.1,60.0);
     glMatrixMode(GL_MODELVIEW);
     glLoadIdentity();
     gluLookAt(0.0f,0.0f,8.0f,
     0.0f,0.0f,0.0f,
     0.0f,1.0f,0.0f);
}

void redraw()
{
rmeln+=6.5;
glutPostRedisplay();
}

//////////////////////
//KEYBOARD AND MAIN//
//////////////////////

void keyboard(unsigned char key,int x,int y)
{
if (key=='1')
{
scena=1;
init1();
glutReshapeFunc(reshape1);
glutDisplayFunc(display1);
glutIdleFunc(redraw1);      
glutReshapeWindow(700, 700);       
}else

if (key=='2')
{
scena=2;
init2();
glutReshapeFunc(reshape2);
glutDisplayFunc(display2);
glutIdleFunc(redraw2);      
glutReshapeWindow(700, 700);       
}else

if (key=='3')
{
scena=3;
init3();
glutReshapeFunc(reshape3);
glutDisplayFunc(display3);
glutIdleFunc(redraw3);      
glutReshapeWindow(700, 700);       
}else
if ((key=='0')||(key=='4'))
{
scena=0;
init();
glutReshapeFunc(reshape);
glutDisplayFunc(display);
glutIdleFunc(redraw);
glutReshapeWindow(700, 700);             
}else

if (scena==2) {
     switch(key) {
                 case 'a':{s2_rx-=10;break;}
                 case 'd':{s2_rx+=10;break;}
                 case 's':{s2_ry-=10;break;}
                 case 'w':{s2_ry+=10;break;}
                 case 'q':{s2_rz-=10;break;}
                 case 'e':{s2_rz+=10;break;}
                 }}
     
if (scena==0) {
     switch(key){
                 case 'd':{if (mx>-8) mx-=0.1;break;}
                 case 'a':{if (mx<8 ) mx+=0.1;break;}
                 case 's':{if (mz>-1) mz-=0.1;break;}
                 case 'w':{if (mz<13 ) mz+=0.1;break;}
                 case 'q':{ry-=1;break;}
                 case 'e':{ry+=1;break;}
}}

glutPostRedisplay();
}

int main(int argc,char ** argv)
{
    scena=0;
    srand(RAND_MAX);
    glutInit(&argc,argv);
    glutInitDisplayMode(GLUT_DOUBLE|GLUT_RGB|GLUT_DEPTH);
    glutInitWindowSize(700,700);
    glutCreateWindow(argv[0]);
    InitLight();
    init();
    glutReshapeFunc(reshape);
    glutDisplayFunc(display);
    glutIdleFunc(redraw);
    glutKeyboardFunc(keyboard);
    glutMainLoop();
    return 0;
}

