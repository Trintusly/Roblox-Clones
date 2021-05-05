

import bpy
bpy.ops.wm.open_mainfile(filepath="/var/www/html/render/BPRAvatar.blend")



HeadImg = bpy.data.images.load(filepath="/var/www/html/render/textures/faces/1.png")
HeadTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
HeadTex.image = HeadImg
Headslot = bpy.data.objects["Head"].active_material.texture_slots.add()
Headslot.texture = HeadTex


bpy.data.objects["Torso"].select = True
bpy.data.objects["Torso"].active_material.diffuse_color = (0/255, 0/255, 0/255)


bpy.data.objects["Head"].select = True
bpy.data.objects["Head"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["RightArm"].select = True
bpy.data.objects["RightArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftArm"].select = True
bpy.data.objects["LeftArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftLeg"].select = True
bpy.data.objects["LeftLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["RightLeg"].select = True
bpy.data.objects["RightLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)


LeftArmImg = bpy.data.images.load(filepath="/var/www/html/storage/shirts/333.png")
LeftArmTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
LeftArmTex.image = LeftArmImg
LeftArmslot = bpy.data.objects["LeftArm"].active_material.texture_slots.add()
LeftArmslot.texture = LeftArmTex

RightArmImg = bpy.data.images.load(filepath="/var/www/html/storage/shirts/333.png")
RightArmTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
RightArmTex.image = RightArmImg
RightArmslot = bpy.data.objects["RightArm"].active_material.texture_slots.add()
RightArmslot.texture = RightArmTex


TorsoImg = bpy.data.images.load(filepath="/var/www/html/storage/shirts/333.png")
TorsoTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
TorsoTex.image = TorsoImg
Torsolot = bpy.data.objects["Torso"].active_material.texture_slots.add()
Torsolot.texture = TorsoTex


objs = bpy.data.objects
objs.remove(objs["LeftLeg"], True)
objs.remove(objs["RightLeg"], True)
objs.remove(objs["Head"], True)


for ob in bpy.context.scene.objects:
    if ob.type == "MESH":
        ob.select = True
        bpy.context.scene.objects.active = ob
    else:
        ob.select = False
bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

obj = bpy.data.objects["Camera"]

pi = 3.14159

obj.location.x = -1.0
obj.location.y = -3.7
obj.location.z = 4.1
obj.rotation_mode = "XYZ"
obj.rotation_euler[0] = 80.0 * (pi / 180.0)

origAlphaMode = bpy.data.scenes["Scene"].render.alpha_mode
bpy.data.scenes["Scene"].render.alpha_mode = "TRANSPARENT"
bpy.data.scenes["Scene"].render.alpha_mode = origAlphaMode
bpy.data.scenes["Scene"].render.filepath = "/var/www/html/storage/thumb/shirts/333.png"
bpy.ops.render.render( write_still=True )

